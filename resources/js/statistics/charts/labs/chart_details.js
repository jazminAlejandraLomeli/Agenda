


export function template_cards(data) {
    const { semesters, string_date } = data;
    
    const container = document.getElementById("grid-container");
    const countElement = document.querySelector(".count");
    const countPromgram = document.querySelector(".promgram");
    const date = document.querySelector(".date_semester");

    const totalGeneral = semesters.reduce((acc, item) => acc + item.total, 0);
    // Limpiar el contenedor para que no se duplique
    container.innerHTML = "";

    // Cambia el contenido de los textos
    date.textContent = string_date;
    countElement.textContent = totalGeneral;
    countPromgram.textContent = semesters[0].programa;

    semesters.forEach((item) => {
        const card = `
      <div class="col-span-12 sm:col-span-6 md:col-span-3 xl:col-span-4">
      <div class="relative w-full p-4 mt-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden group min-h-30 border-b border-cyan-500">
        <p class="absolute text-4xl -top-1 -left-0 text-orange-600 opacity-30 rotate-[0.02rad]">
          <span class="semester">${item.semester}</span>
        </p>
        <div class="text-center mt-2">
          <h2 class="text-5xl font-semibold text-cyan-500 dark:text-orange-400 transition-transform group-hover:scale-105 count">
            ${item.total}
          </h2>
          <p class="mt-1 text-gray-400 dark:text-gray-300 text-sm">Reservaciones</p>
        </div>
        </div>
      </div>
    `;
        container.insertAdjacentHTML("beforeend", card);
    });
}
