/*await new PurgeCSS().purge({
    content: ['**!/!*.php', 'template/template-home.php'],
    css: ['custom.css'],

    console.log(purgecss);
})*/

(async () => {
    const purgecss = await new PurgeCSS().purge({
        css: ['custom.css'],
    });
    alert("ok");
    console.log(purgecss);
})();