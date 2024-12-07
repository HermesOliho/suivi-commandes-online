/**
 *
 * @param {string} dateString
 * @returns {string}
 * @throws If the given string doesn't have a correct date format
 */
export const formatDate = (dateString) => {
    const date = new Date(dateString);
    return `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
};
