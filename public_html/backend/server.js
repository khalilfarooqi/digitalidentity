const express = require('express');
const app = express();
app.set('view engine','jade');

// set our port
const port = 3000;
/**
 * 
 * Configuration
 * - - - - - - - - - - - - - - - 
 * 
 */

//Mongoose connection created
//require('./config/database');
//var db = require('./config/database');
//console.log("connecting--",db);
//mongoose.connect(db.url);


/**
 * 
 * Frontend Routes
 * - - - - - - - - - - - - - - - 
 * 
 */
app.get('/', (req, res) => res.send('Welcome to Tutorialspoint!'));
app.get('/home', function (req, res) {
   res.render('index', {title:'Guru99',message:'Welcome'});
});


// startup our app at http://localhost:3000
app.listen(port, () => console.log(`startup app listening on port ${port}!`));