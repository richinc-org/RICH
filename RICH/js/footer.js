Promise.all([loadHeader(), loadFooter()]).then(() => {
  document.body.classList.add("loaded");
});