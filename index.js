var express = require('express');
var app = express();
app.use(express.json());

app.use(express.static(__dirname + '/pages'));

//importante o modulo de mysql
var mysql = require('mysql');

//criando a variável con que vai ter a referência de conexão
//com o banco de dados
var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "1234",
    database: "OndeHoje"
});

//tentando connectar
//a variável con tem a conexão agora
con.connect(function (err) {
    if (err) throw err;
    console.log("Connected!");
});

const produtos = [];

let idUsuarios = 0;

const router = express.Router();
router.get('/api/produtos', (req, res) => {
    res.status(200).json(produtos);
});
router.post('/api/produtos', (req, res) => {
    var produto = req.body;
    produto.id = 1;
    produtos.push(produto);
    res.status(201).json(produto);
});

//endpoint para listar todos os usuários
router.get('/api/usuarios', (req, res) => {
    //cria a string the consulta no baco do tipo select
    let sql = "SELECT u.id, u.email, u.status FROM usuario u";
    //executando o comando sql com a função query
    //nela passamos a string de consulta
    //após a execução ele retorna o function que vai ter a variável err e result
    //se deu algum erro a variável err terá o erro obtivo
    //caso contrário o result terá dos dados do banco 
    con.query(sql, function (err, result) {
        if (err) throw err;
        res.status(200).json(result);
    });
});

//endpoint para salvar um usuário
router.post('/api/usuarios', (req, res) => {
    var usuario = req.body;
    var sql = '';
    if (usuario.id) {
        sql = `UPDATE usuario SET email = '${usuario.email}', 
        senha = '${usuario.senha}', status = '${usuario.status ? 1 : 0}' 
        WHERE id = ${usuario.id}`;
    } else {
        sql = `INSERT INTO usuario (email, senha, status) VALUES 
    ('${usuario.email}', '${usuario.senha}','${usuario.status ? 1 : 0}')`;
    }
    con.query(sql, function (err, result) {
        if (err) throw err;
    });
    res.status(201).json(usuario);
});

//endpoint para capturar um usuário por id
router.get('/api/usuarios/:id', (req, res) => {
    const id = req.param("id");

    let sql = `SELECT u.id, u.email, u.status FROM usuario u WHERE u.id = ${id}`;
    con.query(sql, function (err, result) {
        if (err) throw err;
        res.status(200).json(result[0]);
    });
});

//endpoint para excluir um usuário
router.delete('/api/usuarios/:id', (req, res) => {
    const id = req.param("id");

    var sql = `DELETE FROM usuario WHERE id = ${id} `;
    con.query(sql, function (err, result) {
        if (err) throw err;
    });

    res.status(200).send(`usuario com id ${id} excluído`);
});


// Endpoint para listar todos os estabelecimentos
router.get('/api/estabelecimentos', (req, res) => {
    let sql = "SELECT * FROM estabelecimento";
    con.query(sql, function (err, result) {
        if (err) throw err;
        res.status(200).json(result);
    });
});

// Endpoint para adicionar um novo estabelecimento
router.post('/api/estabelecimentos', (req, res) => {
    var estabelecimento = req.body;
    var sql = `INSERT INTO estabelecimento (nome, endereco, avaliacao) VALUES 
               ('${estabelecimento.nome}', '${estabelecimento.endereco}', ${estabelecimento.avaliacao})`;
    con.query(sql, function (err, result) {
        if (err) {
            console.error("Erro ao inserir no banco de dados:", err);
            res.status(500).json({ error: "Erro ao inserir no banco de dados" });
            return;
        }
        res.status(201).json({ id: result.insertId, ...estabelecimento });
    });
});

// Endpoint para atualizar um estabelecimento existente
router.put('/api/estabelecimentos/:id', (req, res) => {
    const id = req.params.id;
    var estabelecimento = req.body;
    var sql = `UPDATE estabelecimento SET nome = '${estabelecimento.nome}', endereco = '${estabelecimento.endereco}', 
               avaliacao = ${estabelecimento.avaliacao} WHERE id = ${id}`;
    con.query(sql, function (err, result) {
        if (err) throw err;
        res.status(200).json(estabelecimento);
    });
});

// Endpoint para excluir um estabelecimento
router.delete('/api/estabelecimentos/:id', (req, res) => {
    const id = req.params.id;
    var sql = `DELETE FROM estabelecimento WHERE id = ${id}`;
    con.query(sql, function (err, result) {
        if (err) throw err;
        res.status(200).send(`Estabelecimento com id ${id} excluído`);
    });
});

// Endpoint para capturar um estabelecimento por ID
router.get('/api/estabelecimentos/:id', (req, res) => {
    const id = req.params.id;
    let sql = `SELECT * FROM estabelecimento WHERE id = ${id}`;
    con.query(sql, function (err, result) {
        if (err) throw err;
        res.status(200).json(result[0]);
    });
});


app.use(router);

app.get('/', (req, res) => {
    res.redirect('/Login/login.html'); // Ajuste o caminho aqui
});

const port = 3000;
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});