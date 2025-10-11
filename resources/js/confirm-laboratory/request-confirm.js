import axios from "axios";

export const requestConfirm = async (id) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                id: parseInt(id),
            };
                        
            const data = await axios.post(`/agenda/allow-laboratory`, Data);
            
            if (data.status === 204) {
                resolve({
                    title: "¡Éxito!",
                    message: "La reservación se publicó correctamente y se envío un correo de confirmación.",
                });
            }
        } catch (error) {
            const { status } = error;
            if (status == 400) {
                // En caso de que se dupweblique un dato
                const { errors } = error.response.data;
                reject({
                    status: 400,
                    message: errors.Id[0], // Mostrar el error, siempre sera 1
                });
            } else {
                reject(error);
            }
        }
    });
};
