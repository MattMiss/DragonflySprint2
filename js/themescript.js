let theme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', theme);
console.log("Theme loaded");