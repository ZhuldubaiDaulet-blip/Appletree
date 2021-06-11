// This code empowers all input tags having a placeholder and data-slots attribute
// The code is imported from StackOverflow, user's answer.
// https://stackoverflow.com/questions/12578507/implement-an-input-with-a-mask
document.addEventListener('DOMContentLoaded', () => {
    for (const obj of document.querySelectorAll("[placeholder][data-slots]")) {
        const pattern = obj.getAttribute("placeholder"),
            slots = new Set(obj.dataset.slots || "_"),
            prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
            first = [...pattern].findIndex(c => slots.has(c)),
            accept = new RegExp(obj.dataset.accept || "\\d", "g"),
            clean = input => {
                input = input.match(accept) || [];
                return Array.from(pattern, c =>
                    input[0] === c || slots.has(c) ? input.shift() || c : c
                );
            },
            format = () => {
                const [i, j] = [obj.selectionStart, obj.selectionEnd].map(i => {
                    i = clean(obj.value.slice(0, i)).findIndex(c => slots.has(c));
                    return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                });
                obj.value = clean(obj.value).join``;
                obj.setSelectionRange(i, j);
                back = false;
            };
        let back = false;
        obj.addEventListener("keydown", (e) => back = e.key === "Backspace");
        obj.addEventListener("input", format);
        obj.addEventListener("focus", format);
        obj.addEventListener("blur", () => obj.value === pattern && (obj.value=""));
    }
});