const {Router}=require('express')
const router=Router();
const {
    getUsers,
    getUsersByUsername,
    insertUser,
    getDatos,
    insertDatos,
    getRiegos,
    insertRiegos
}=require('../controllers/index.contoller');

router.get('/api/user', getUsers);
router.post('/api/user/:username', getUsersByUsername);
router.post('/api/user', insertUser)
router.get('/api/datos',getDatos)
router.post('/api/datos',insertDatos)
router.get('/api/riegos',getRiegos)
router.post('/api/riegos',insertRiegos)

module.exports=router;