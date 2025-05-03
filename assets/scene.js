// scene.js

// Créer une scène
var scene = new THREE.Scene();

// Créer une caméra (vue perspective)
var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

// Créer un rendu WebGL
var renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
document.getElementById('webgl-container').appendChild(renderer.domElement);

// Créer un objet (exemple : une planète)
var geometry = new THREE.SphereGeometry(5, 32, 32); // Rayon, segments horizontaux, verticaux
var material = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
var sphere = new THREE.Mesh(geometry, material);
scene.add(sphere);

// Appliquer une texture (exemple : Terre)
var textureLoader = new THREE.TextureLoader();
var earthTexture = textureLoader.load('textures/earth.jpg'); // Remplace par le chemin de ta texture
var earthMaterial = new THREE.MeshBasicMaterial({ map: earthTexture });
var earth = new THREE.Mesh(geometry, earthMaterial);
earth.position.x = 10; // Positionner la Terre à distance
scene.add(earth);

// Ajouter une lumière
var ambientLight = new THREE.AmbientLight(0x404040, 1); // Lumière douce
scene.add(ambientLight);

// Ajouter une lumière directionnelle (simulant une étoile)
var directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(10, 10, 10); // Position de la lumière
scene.add(directionalLight);

// Positionner la caméra
camera.position.z = 20;

// Ajouter un contrôle de caméra (OrbitControls pour navigation avec souris)
var controls = new THREE.OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.25;
controls.enableZoom = true;

// Fonction d'animation
function animate() {
    requestAnimationFrame(animate);

    // Faire tourner la planète
    sphere.rotation.x += 0.01;
    sphere.rotation.y += 0.01;

    // Faire tourner la Terre
    earth.rotation.y += 0.005;

    // Rendre la scène
    renderer.render(scene, camera);
}

// Lancer l'animation
animate();
