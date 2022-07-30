const {Pool}=require('pg')
require('dotenv').config()
const bcrypt=require('bcrypt')

const cryptimes=parseInt(process.env.ROUNDS);

const pool=new Pool({
    host:process.env.DB_HOST,
    user:process.env.DB_USER,
    database:process.env.DB_DB,
    password:process.env.DB_PASS
})

const getUsers = async (req,res) => {
    const response= await pool.query('SELECT * FROM users');
    console.log(response.rows)
    res.status(200).json(response.rows)
}
const getUsersByUsername = async (req,res) => {
    const password=req.body.password
    const username=req.params.username
    const response= await pool.query('SELECT * FROM users WHERE username = $1',[username]);
    
    if(response.rowCount===0){
        res.json({
            "error":1,
            "message":"Usuario no encontrado"
        })
    }else{
        bcrypt.compare(password,response.rows[0].password).then((equal)=>{
            if(equal){
                res.status(200).json(response.rows[0])
            }else{
                res.json({
                    "error":2,
                    "message":"Contraseña invalida"
                })
            }
        })
    }
}

const insertUser =  async (req,res)=>{
    const {username,password}=req.body
    const userRegistered = await pool.query('SELECT * FROM users');
    console.log(userRegistered.rowCount)
    if(userRegistered.rowCount===0){
        bcrypt.hash(password,cryptimes,async(err,passcrypted)=>{
            if (err) {
                console.log(err)
                res.send(err)
            } else {
                console.log(passcrypted)
                const response=await pool.query('INSERT INTO users (username,password) VALUES ($1,$2)',[username, passcrypted])
                res.send('user was inserted')
            }
        })
    }else{
        res.send("Ya se ha registrado el maximo de usuarios permitidos")
    }
}

const getDatos=async (req,res)=>{
    const response=await pool.query('SELECT * FROM datos')

    res.send(response.rows)
}

const insertDatos=async (req,res)=>{
    const {temp,humedad,agua,suelo,bomba}=req.body
    const date =  new Date().toLocaleString("es-MX",{ timeZone:"America/Mexico_city",year:"numeric",month:"2-digit",day:"2-digit", hour12:false, hour:"2-digit", minute:"2-digit", second: "2-digit"});
    fecha=date.slice(0,10)
    hora=date.slice(11,19)

    const response=await pool.query('INSERT INTO datos (temp, humedad, agua, suelo, bomba, hora, fecha) VALUES ($1,$2,$3,$4,$5,$6,$7)',
        [temp,humedad,agua,suelo,bomba,hora,fecha]);

    console.log(response.rows)
    res.send(response.rows)
}


const getRiegos=async(req,res)=>{
    const response=await pool.query('SELECT * FROM riegos')
    res.json(response.rows)
}

const insertRiegos=async(req,res)=>{
    const date=  new Date().toLocaleString("es-MX",{ timeZone:"America/Mexico_city",year:"numeric",month:"2-digit",day:"2-digit", hour12:false, hour:"2-digit", minute:"2-digit", second: "2-digit"});
    const fecha=date.slice(0,10)
    const hora=date.slice(11,19)
    const {agua} = req.body
    const response=await pool.query('INSERT INTO riegos (hora,fecha,agua) VALUES ($1,$2,$3)',[hora,fecha,agua])
    res.json({
        data:response.rows,
        message:"Dato insertado correctamente"
    })
}
module.exports={
    getUsers,
    insertUser,
    getUsersByUsername,
    getDatos,
    insertDatos,
    getRiegos,
    insertRiegos
}