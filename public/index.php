<?php

require '../vendor/autoload.php';

$app = new \Slim\App ([

	'settings'=> [
		'displayErrorDetails' =>true,
	]

]);
require '../app/container.php';
$container = $app->getContainer();

$app->get('/',App\Controllers\PagesController::class . ':home');

$app->post('/',App\Controllers\PagesController::class . ':Phome');

$app->get('/p/{page}',App\Controllers\PagesController::class . ':pages');

$app->get('/PageAdmin/GestionAnnonce',App\Controllers\PagesController::class . ':getPageAdminGestionAnonnce');

$app->get('/PageAdmin',App\Controllers\PagesController::class . ':getPageAdmin')->setName('PageAdmin');

$app->get('/Inscription',App\Controllers\PagesController::class . ':getInscri')->setName('Inscription');

$app->post('/Inscription',App\Controllers\PagesController::class . ':postInscri');

$app->get('/AjouteAnnonce',App\Controllers\PagesController::class . ':getAjouteAn')->setName('AjouteAnnonce');

$app->post('/AjouteAnnonce',App\Controllers\PagesController::class . ':postAjouteAn');

$app->get('/loginU',App\Controllers\PagesController::class . ':getLoginU')->setName('loginU');

$app->post('/loginU',App\Controllers\PagesController::class . ':postLoginU');

$app->post('/PageAdmin',App\Controllers\PagesController::class . ':postPageAdmin');

$app->get('/PageUser',App\Controllers\PagesController::class . ':getPageU')->setName('PageUser');

$app->post('/PageUser',App\Controllers\PagesController::class . ':postPageU');

$app->get('/AjouterMarque',App\Controllers\PagesController::class . ':getMarque')->setName('AjouterMarque');

$app->post('/AjouterMarque',App\Controllers\PagesController::class . ':postMarque');

$app->get('/AjouterModele',App\Controllers\PagesController::class . ':getModele')->setName('AjouterModele');

$app->post('/AjouterModele',App\Controllers\PagesController::class . ':postModele');

$app->get('/AfficherAnnonce',App\Controllers\PagesController::class . ':getAfficherAnnonce')->setName('AfficherAnnonce');

$app->get('/Rechercher',App\Controllers\PagesController::class . ':getRecherche')->setName('Recherecher');

$app->post('/Rechercher',App\Controllers\PagesController::class . ':postRecherche');

$app->get('/PageAdmin/GestionAnnonceurs',App\Controllers\PagesController::class . ':getGestionAnnonceurs')->setName('GestionAnnonceurs');

$app->post('/ModifierAn',App\Controllers\PagesController::class . ':postModifierAn');

$app->get('/logout',App\Controllers\PagesController::class . ':getLogout')->setName('logout');

$app->run();
