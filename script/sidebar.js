document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("toggleSidebar");
  const sidebar = document.getElementById("sidebar");
  const pageContainer = document.querySelector(".ml-64, .ml-16");
  const stateInput = document.getElementById("sidebar_state_input");

  // --- Part A: Initialization (Restore State on Load) ---
  const savedState = localStorage.getItem("sidebarState");

  if (savedState === "collapsed") {
    sidebar.classList.add("collapsed");
    // Initialize the page container margin correctly based on the collapsed state
    pageContainer.classList.remove("ml-64");
    pageContainer.classList.add("ml-16");
    stateInput.value = "collapsed";
  } else {
    // Ensure it's expanded by default if no state is saved or if state is 'expanded'
    sidebar.classList.remove("collapsed");
    pageContainer.classList.remove("ml-16");
    pageContainer.classList.add("ml-64");
    stateInput.value = "expanded";
  }

  // --- Part B: Persistence (Save State on Click) ---
  toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");

  if (sidebar.classList.contains("collapsed")) {
    localStorage.setItem("sidebarState", "collapsed");
    stateInput.value = "collapsed";

    requestAnimationFrame(() => {
                pageContainer.classList.remove("ml-64");
                pageContainer.classList.add("ml-16");
            });
  } else {
    localStorage.setItem("sidebarState", "expanded");
    stateInput.value = "expanded";

    requestAnimationFrame(() => {
                pageContainer.classList.remove("ml-16");
                pageContainer.classList.add("ml-64");
            });
  }
});

});
