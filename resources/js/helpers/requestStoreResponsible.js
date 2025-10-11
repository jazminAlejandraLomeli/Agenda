import axios from "axios"
import { showLoader, hideLoader } from "./loader.js";

export const requestStoreResponsible = async (dataPost = {}) => {
    return new Promise(async (resolve, reject) => {
        showLoader('Guardando la persona responsable');
        try {
            const response = await axios.post(`/agenda/responsible/store`,dataPost);

            if (response.status === 201) {
                resolve(response.data);
            }

            reject({
                title: 'Error!',
                message: 'Hubo un error al obtener los permisos del rol'
            });



        } catch (error) {
            console.error(error);
            reject(error);
        } finally {
            hideLoader();
        }






    });

}