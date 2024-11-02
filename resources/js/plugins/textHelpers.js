export const useTextHelpers = () => {
    const limitText = (text, length) => {
        if (!text) return "";
        return text.length > length ? text.substring(0, length) + "..." : text;
    };

    const highlightText = (text, searchTerm) => {
        if (!searchTerm) return text;
        const regex = new RegExp(`(${searchTerm})`, "gi");
        return text.replace(regex, '<span class="bg-yellow-200">$1</span>');
    };

    return {
        limitText,
        highlightText,
    };
};
