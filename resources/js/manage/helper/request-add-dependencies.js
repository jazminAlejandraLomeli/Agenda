import axios from "axios";

export const requestAddDependency = async (Id, Group, name) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                Grupo: parseInt(Group),
                Nombre: name,
            };

            const { status } = await axios.post(
                `/agenda/dependencies/store`,
                Data
            );
            if (status === 200) {
                resolve({
                    title: "¡Éxito!",
                    message: "Dependencia creada correctamente.",
                });
            }

            reject({
                title: "¡Error!",
                message: "Hubo un error al agregar el dato.",
            });
        } catch (error) {
            reject(error);
        }
    });
};
