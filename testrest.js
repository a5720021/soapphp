var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var mysql = require('mysql');
var basicAuth = require('express-basic-auth')
var http = require('http')

// create basic authentication
app.use(basicAuth({
    users: { 'admin': '123456' },
    unauthorizedResponse: getUnauthorizedResponse
}))
 
function getUnauthorizedResponse(req) {
    return req.auth ?
        ('Username or Password is incorrect') :
        'Username or Password is incorrect'
}

// create database connection
var con = mysql.createConnection({
  host: "127.0.0.1",
  user: "mungyoyo",
  password: "",
  database: "eldercare"
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});

// parse application/json
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({
    extended: true
}));

var port = process.env.PORT || 8080;        // set our port

//function welcome to user (accessed at https://soap-php-mungyoyo.c9users.io)
app.get('/', function(req, res) {
    res.json({ message: 'Welcome to user' });   
});

//get all the elders (accessed at GET https://soap-php-mungyoyo.c9users.io/elder)
app.get('/elder', function (req, res) {
  var sql = "select * from elder"
  con.query(sql, function (err, result) {
  if (err) throw err;
    res.json({ result });
  });
});

//create a elder (accessed at POST https://soap-php-mungyoyo.c9users.io/elder)
app.post('/elder', function(req, res) {
  var name = req.body.e_name
  var sql = "insert into elder (e_name) VALUES ('"+ name +"')";
  con.query(sql, function (err, result) {
  if (err) throw err;
     console.log("Insert Complete")
  });
})

//get id of elder (accessed at GET https://soap-php-mungyoyo.c9users.io/elder/:e_id)
app.get('/elder/:e_id', function(req, res) {
  var sql = "select * from elder WHERE e_id = " + req.params.e_id
  con.query(sql, function (err, result) {
  if (err) throw err;
     if (result.length==0) {
        res.statusCode = 404
        res.json({ message: '404 - Bear not found!' });
      }else{
        res.json(result);
      };
  });
})

//delete id of elder (accessed at DELETE https://soap-php-mungyoyo.c9users.io/elder/:e_id)    
app.delete('/elder/:e_id', function(req, res) {
  var id = req.params.e_id
  var sql = "DELETE from elder WHERE e_id = " + id
  con.query(sql, function (err, result) {
  if (err) throw err;
      console.log("Delete Complete" + id)   
  });
});

//put id of elder (accessed at PUT https://soap-php-mungyoyo.c9users.io/elder/:e_id)
app.put('/elder/:e_id', function(req, res) {
  var id = req.params.e_id
  var name = req.body.e_name;
  var sql = "UPDATE elder set e_name = '" + name + "' WHERE e_id = " + id
  con.query(sql, function (err, result) {
    if (err) throw err;
      console.log("Update Complete " + id + " is " + name)
    });
});

// START THE SERVER
app.listen(port);
console.log('Start on port ' + port);