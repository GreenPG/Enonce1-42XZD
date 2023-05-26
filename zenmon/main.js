const express = require('express');
const { parseArgs } = require('util');
const app  = express();

app.use(express.json());

app.listen(
	8082,
	() => console.log('cest ici http://localhost:8081')
);

const tests = [
	{id:1, name: 'nays', mail: 'mathys.vitiell@gmail.com', happiness: 5, animal: 'cat'},
	{id:2, name: 'gigi', mail: 'gigi@outlook.fr', happiness: 4, animal: 'chien'},
];
const thename = [
];
let searchname = "";




app.get('/api/test', (req, res) => {
	res.send(tests);
});
app.get('/api/nom', (req, res) => {
	const termeknevFlat = thename.flat().map(({ name }) => name);
	res.send(thename);
});

app.post('/api/nom', (req, res) => {

	searchname = req.body.name;
	//thename.push(thenameonly);
	//res.send(thenameonly);
	console.log(searchname);
	const perso = tests.find(c => c.name == searchname);
	if (!perso) res.status(404).send('Ne trouve pas name');
	res.send(perso);
	console.log(perso);

});

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



