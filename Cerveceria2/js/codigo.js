window.addEventListener("DOMContentLoaded", () => {
  console.log("El DOM está listo");

  // Selección de elementos
  const container = document.querySelector(".container");
  const btnIn = document.getElementById("btn-sign-in");
  const btnUp = document.getElementById("btn-sign-up");

  // Verificar si los elementos existen
  if (!container || !btnIn || !btnUp) {
    console.error("Algunos elementos del DOM no fueron encontrados.");
    return;
  }

  // Agregar eventos
  btnIn.addEventListener("click", () => {
    container.classList.remove("toggle");
    console.log("Botón 'Iniciar Sesión' presionado");
  });

  btnUp.addEventListener("click", () => {
    container.classList.add("toggle");
    console.log("Botón 'Registrarse' presionado");
  });
});
