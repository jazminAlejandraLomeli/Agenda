import axios from "axios"

export const requestResetPassword = async (id) => {
    return new Promise(async (resolve, reject) => {
    
        try{
            const {status} = await axios.get(`/users/reset-password/${id}`);
            if(status === 204){
                resolve({
                    title : 'Contraseña restablecida',
                    message : 'Se ha restablecido la contraseña del usuario'
                });
            }

            reject({
                title : 'Error al restablecer contraseña',
                message : 'No se ha podido restablecer la contraseña del usuario'
            });

        }catch(error){
            console.error(error);
            reject(error);
        }

            

            
        
    });

}