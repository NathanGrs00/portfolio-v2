const filterButton = document.getElementById("project-filter-button");
const filterMenu = document.getElementById("project-filter-menu");
const filterContainer = document.querySelector(".project-filter");

const projects = document.querySelectorAll(".project-filter-item");

// Filter groups: checkbox name -> matching data attribute on project item
const filterGroups = [
  { name: "project-tag", dataKey: "projectTags" },
  { name: "project_size", dataKey: "projectSize" },
  { name: "project_people", dataKey: "projectPeople" },
  { name: "project_context", dataKey: "projectContext" },
];

// Open / close filter menu
filterButton.addEventListener("click", (event) => {
  event.stopPropagation();

  filterMenu.classList.toggle("is-open");
});

// Close when clicking outside
document.addEventListener("click", (event) => {
  if (!filterContainer.contains(event.target)) {
    filterMenu.classList.remove("is-open");
  }
});

// Filter projects
function applyFilters() {
  // Gather selected values per group
  const selections = filterGroups.map((group) => {
    const options = document.querySelectorAll(`input[name="${group.name}"]`);

    const selectedValues = Array.from(options)
      .filter((option) => option.checked)
      .map((option) => option.value);

    return { ...group, selectedValues };
  });

  projects.forEach((project) => {
    const matches = selections.every((group) => {
      if (group.selectedValues.length === 0) return true;

      const projectValues = (project.dataset[group.dataKey] || "")
        .split(",")
        .filter(Boolean);

      // OR within a group: project matches if it has at least one selected value
      return group.selectedValues.some((value) =>
        projectValues.includes(value),
      );
    });

    project.style.display = matches ? "" : "none";
  });
}

// Attach listeners to every filter checkbox (tags + new groups)
filterGroups.forEach((group) => {
  const options = document.querySelectorAll(`input[name="${group.name}"]`);

  options.forEach((option) => {
    option.addEventListener("change", applyFilters);
  });
});
