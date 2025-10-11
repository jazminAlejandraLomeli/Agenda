import axios from "axios";

export const requestAddPlace = async (id, group, name, color, text_color) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                Grupo: parseInt(group),
                Nombre: name,
                Color: color,
                Color_Texto: text_color,
            };
            const { status } = await axios.post(`/agenda/places/store`, Data);
            if (status === 200) {
                resolve({
                    title: "¡Éxito!",
                    message: "Lugar creado con éxito.",
                });
            }
        } catch (error) {
            const { status } = error;
            if (status == 409) {
                // En caso de que se duplique un dato
                const { msg } = error.response.data;
                reject({
                    title: "¡Error!",
                    message: msg,
                });
            } else {
                reject(error);
            }
        }
    });
};
