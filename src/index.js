const express=require('express');
const app=express();
const cors=require('cors')

//server port 
const port = 2608;

// middlewares
app.use(express.json());
app.use(express.urlencoded({extended:false}));
app.use(cors({
    origin:'*'
}));

// routes
app.use(require('./routes/index.js'))

app.listen(port,()=>{
    console.log('server on port: '+ port)
})