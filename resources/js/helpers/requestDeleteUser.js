import axios from "axios"

export const requestDeleteUser = async (id) => {
    return new Promise(async (resolve, reject) => {
    
        try{
            const {status} = await axios.delete(`/users/delete/${id}`);
            if(status === 204){
                resolve({
                    title : 'Usuario eliminado',
                    message : 'Se ha eliminado el usuario'
                });
            }

            reject({
                title : 'Error al eliminar',
                message : 'No se ha podido eliminar el usuario'
            });

        }catch(error){
            console.error(error);
            reject(error);
        }

            

            
        
    });

}