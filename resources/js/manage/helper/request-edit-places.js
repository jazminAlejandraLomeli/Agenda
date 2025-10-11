import axios from "axios";

export const requestEditPlace = async (id, group, name, color, text_color) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                Id: parseInt(id),
                Grupo: parseInt(group),
                Nombre: name,
                Color: color,
                Color_Texto: text_color,
            };

            const { status } = await axios.post(`/agenda/places/update`, Data);
            if (status === 204) {
                resolve({
                    title: "¡Éxito!",
                    message: "El el registro fue editado correctamente.",
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
