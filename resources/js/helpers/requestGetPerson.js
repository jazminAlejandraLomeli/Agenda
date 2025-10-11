import axios from "axios"
import { showLoader, hideLoader } from "./loader.js";

export const requestGetPerson = async (code, type) => {
    return new Promise(async (resolve, reject) => {
        showLoader('Buscando a la persona');
        try {
            const response = await axios.get(`/agenda/api/getPerson/${code}/${type}`);

            if (response.status === 200) {
                resolve(response.data);
            }

            reject({
                title: 'Error!',
                message: 'Hubo un error al obtener los datos de la persona ligada al código'
            });



        } catch (error) {
            console.error(error);
            reject(error);
        } finally {
            hideLoader();
        }






    });

}