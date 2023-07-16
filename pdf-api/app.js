const express = require('express');
const bodyParser = require('body-parser');
const puppeteer = require('puppeteer');
const { JSDOM } = require('jsdom');
const fs = require('fs')
const { createCanvas, loadImage } = require('canvas');

const app = express();
app.use(bodyParser.json());

app.listen(3000, () => {
  console.log('Server is running on port 3000');
});

app.post('/itinerary', async (req, res) => {
  // Récupération des informations reçues
  const { itinerary, name, token, points } = req.body

  if (!itinerary || !name || !token || !points) {
    return res.status(400).json({ statut: "Erreur", message: "JSON incorrect"})
  }

  // Vérification du token
  if (!(await verify(token))) {
    return res.status(401).json({ statut: "Erreur", message: "Jeton incorrect" })
  }

  await generatePDF(itinerary, name, points)

  return res.status(204).end()
})

app.get('/itinerary/:id', async (req, res) => {
  // Récupération de l'identifiant d'iténéraire
  const { id } = req.params

  // Récupération du jeton d'authentification
  const { token } = req.body

  // Vérification des informations reçues
  if (!id || !token) {
    return res.status(400).json({ statut: "Erreur", message: "JSON incorrect"})
  }

  // Vérification du token
  if (!(await verify(token)))  {
    return res.status(401).json({ statut: "Erreur", message: "Jeton incorrect" })
  }

  try {
    const pdfPath = `pdf/pdf_${id}.pdf`
    const pdfFile = fs.readFileSync(pdfPath)

    // Définition des entêtes
    res.setHeader('Content-Type', 'application/pdf')
    res.setHeader('Content-Disposition', `attachement; filename="${pdfPath}"`)

    return res.status(200).send(pdfFile)
  } catch {
    return res.status(404).json({ statut: "Erreur", message: "Identifiant introuvable" })
  }
})

async function verify(token) {
  const response = await fetch("http://localhost:4000/verify.php", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ jeton : token })
  })
  return response.status == 200
}

async function generatePDF(itinerary, name, coordinates) {

const canvasWidth = 800;
const canvasHeight = 600;
const canvas = createCanvas(canvasWidth, canvasHeight);
const context = canvas.getContext('2d');


let minX = Number.POSITIVE_INFINITY;
let minY = Number.POSITIVE_INFINITY;
let maxX = Number.NEGATIVE_INFINITY;
let maxY = Number.NEGATIVE_INFINITY;

coordinates.forEach((coord) => {
  const lon = coord.lon;
  const lat = coord.lat;
  minX = Math.min(minX, lon);
  minY = Math.min(minY, lat);
  maxX = Math.max(maxX, lon);
  maxY = Math.max(maxY, lat);
});

// Calculez les facteurs d'échelle pour ajuster les coordonnées à la toile
const scaleX = canvasWidth / (maxX - minX);
const scaleY = canvasHeight / (maxY - minY);

// Dessinez le trajet sur la toile
context.strokeStyle = '#FF0000'; // Couleur du trajet (rouge dans cet exemple)
context.lineWidth = 3; // Épaisseur du trait du trajet
context.beginPath();
coordinates.forEach((coord) => {
  const lon = coord.lon;
  const lat = coord.lat;
  const x = (lon - minX) * scaleX;
  const y = canvasHeight - (lat - minY) * scaleY;
  context.lineTo(x, y);
});
context.stroke();

// Exportez la toile en tant qu'image
const outputImagePath = 'pdf/image-sortie.jpg';
const outputStream = fs.createWriteStream(outputImagePath);
const stream = canvas.createJPEGStream();
stream.pipe(outputStream);
outputStream.on('finish', () => {
  console.log(`L'image a été générée et enregistrée sous ${outputImagePath}.`);
});
}