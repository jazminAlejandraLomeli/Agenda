import axios from "axios"
import { showLoader, hideLoader } from "./loader.js";

export const requestStoreTitleEvent = async (dataPost = {}) => {
    return new Promise(async (resolve, reject) => {
        showLoader('Guardando el título del evento');
        try {
            const response = await axios.post(`/agenda/title/store`,dataPost);

            if (response.status === 201) {
                resolve(response.data);
            }

            reject({
                title: 'Error!',
                message: 'Hubo un error al procesar la solicitud para guardar el título del evento'
            });


        } catch (error) {
            console.error(error);
            reject(error);
        } finally {
            hideLoader();
        }






    });

}