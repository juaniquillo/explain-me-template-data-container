import './style.css';

// Theme toggle: explicit choice wins and persists; with no stored choice
// the inline head script already applied the OS preference.
(document.getElementById('theme-toggle') as HTMLButtonElement).addEventListener('click', () => {
    const dark = document.documentElement.classList.toggle('dark');
    try {
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    } catch { /* private mode: theme just won't persist */ }
});
