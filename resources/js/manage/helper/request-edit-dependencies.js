import axios from "axios";

export const requestEditDependencies = async (Id, Group, name) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                Id: parseInt(Id),
                Grupo: parseInt(Group),
                Nombre: name,
            };
            const { status } = await axios.post(
                `/agenda/dependencies/update`,
                Data
            );

            if (status === 204) {
                resolve({
                    title: "¡Éxito!",
                    message: "El el registro fue editado correctamente.",
                });
            }

            reject({
                title: "¡Error!",
                message: "Hubo un error al actualiazar el dato.",
            });
        } catch (error) {
            reject(error);
        }
    });
};


