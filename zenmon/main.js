const express = require('express');
const app  = express();

app.use(express.json());

app.listen(
	8080,
	() => console.log('cest ici http://localhost:8080')
);

const tests = [
	{id:1, name: 'nathys'},
	{id:2, name: 'gigi'},
];

app.get('/api/test', (req, res) => {
	res.send(tests);
});

app.post('/api/test', (req, res) => {
	const test = {
	id: tests.length + 1,
	name: req.body.name
	};
	tests.push(test);
	res.send(test);
});
