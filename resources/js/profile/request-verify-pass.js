import axios from "axios";

/* 
    Funcion que hace la peticion al servidor para verificar que la contraseña ingresada es la contraseña actual
*/
export const requestVerify = async (pass) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                Pass: pass,
            };

            const { status } = await axios.post(
                `/agenda/profile/verify_pass`,
                Data
            );

            if (status === 200) {
                resolve({
                    status: 200,
                });
            }
        } catch (error) {
            reject(error);
        }
    });
};


/* 
    Funcion que hace la peticion al servidor para actualizar la contraseña del usuario de la sesion
*/
export const requestChangePassword = async (pass) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                Pass: pass, 
            };

            const { status } = await axios.post(
                `/agenda/profile/change_password`,
                Data
            );
            if (status === 200) {  // Success
                resolve({
                    tittle: "¡Éxito!",
                    message: "La contraseña fue actualizada",
                });
            }
        } catch (error) { // Error
            const { status } = error;
            let message;
            if (status == 400 || status == 500) {   // Contraseña erronea o falla en el servidor
                const { msg } = error.response.data;
                message = msg;
                console.log(message);
            } else {  // Errores de laravel 
                console.error(error.response);  
                const { errors } = error.response.data;
                message = errors.Pass[0];
            }

            reject({
                tittle: "¡Error!",
                message: message,
            });
        }
    });
};
