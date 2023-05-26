/*
*	DESCRIPTION:
*		Basic API to retrieve data from a wordpress survey and manipulate it
*
*	AUTHOR :
*		CHAKERS {
*			Mathys VITIELLO,
*			Gillian PASQUETTE,
*			Gabriel TOUZALIN
*		}
*/
const express = require('express');
const { parseArgs } = require('util');
const app  = express();

app.use(express.json());

// API INIT //

app.listen(
	8082,
	() => console.log("Lancement de l'api chatastique!")
);

// TEST DATA //

const tests = [
	{
		"id": 1,
		"name": "Jean",
		"mail": "mathys.vitiell@gmail.com",
		"happiness": "5",
		"animal": "cat"
	  },
	  {
		"id": 2,
		"name": "Maxime",
		"mail": "gigi@outlook.fr",
		"happiness": "4",
		"animal": "chien"
	  },
	  {
		"id": 3,
		"name": "axel",
		"mail": "gabriel.touzalin@gmail.com",
		"happiness": "1",
		"animal": "poule"
	  },
	  {
		"id": 4,
		"name": "mathys",
		"mail": "gabriel.touzalin@gmail.com",
		"happiness": "8",
		"animal": "dinosaure"
	  },
	  {
		"id": 5,
		"name": "Doc",
		"mail": "gabriel.touzalin@gmail.com",
		"happiness": "10",
		"animal": "le chien de camille"
	  },
	  {
		"id": 6,
		"name": "gabriel",
		"mail": "gabriel.touzalin@gmail.com",
		"happiness": "2",
		"animal": "citron"
	  },
	  {
		"id": 7,
		"name": "gilian",
		"mail": "gabriel.touzalin@gmail.com",
		"happiness": "7",
		"animal": "cochon"
	  }
];


// RETRIEVE ALL SURVEY ENTRIES //

app.get('/api/test', (req, res) => {
	res.send(tests);
});




// RETRIEVE FAVORITE ANIMAL FROM USER //

app.post('/api/nom', (req, res) => {
	let searchname = "";
	searchname = req.body.name;
	const perso = tests.find(c => c.name == searchname);
	if (!perso) res.status(404).send('Ne trouve pas name');
	if (!perso) console.log ("Pas de resultat pour : " + searchname);
	res.send(perso);
	if (perso) console.log("L'animal preferee de " + searchname + " est : " + perso.animal);
});


// UPDATE API DATA //

app.post('/api/test', (req, res) => {
	const test = {
	id: tests.length + 1,
	name: req.body.name,
	mail: req.body.mail,
	happiness: req.body.happiness,
	animal: req.body.animal,
	};
	tests.push(test);
	res.send(test);
});

// SHOW USER ENTRIES //

app.get('/api/test/:name', (req, res) => {
	const perso = tests.find(c => c.name == req.params.name);
	if (!perso) res.status(404).send('Ne trouve pas name');
	res.send(perso);
});
