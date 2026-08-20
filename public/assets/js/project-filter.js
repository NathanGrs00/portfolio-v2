const filterButton = document.getElementById("project-filter-button");
const filterMenu = document.getElementById("project-filter-menu");
const filterContainer = document.querySelector(".project-filter");

const filterOptions = document.querySelectorAll('input[name="project-tag"]');

const projects = document.querySelectorAll(".project-filter-item");

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
filterOptions.forEach((option) => {
  option.addEventListener("change", () => {
    const selectedTags = Array.from(filterOptions)
      .filter((option) => option.checked)
      .map((option) => option.value);

    projects.forEach((project) => {
      const projectTags = (project.dataset.projectTags || "")
        .split(",")
        .filter(Boolean);

      const matches = selectedTags.every((tagId) =>
        projectTags.includes(tagId),
      );

      project.style.display =
        selectedTags.length === 0 || matches ? "" : "none";
    });
  });
});
