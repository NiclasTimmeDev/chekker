export default {
    /**
     * Add item to local storage.
     *
     * @param {String} key
     *   The key of the new entry.
     * @param {String} value
     *   The value of the new entry.
     * @param {Boolean} force
     *   Optional. If true, existing key in local storage will be overriden
     * @return Boolean.
     *   True if item was set.
     */
    add(key, value, force = false) {
        if (!localStorage.getItem(key)) {
            localStorage.setItem(key, value);
            return true;
        }

        // Override if force is true.
        if (force) {
            localStorage.setItem(key, value);
            return true;
        }

        // Only add item if item not exists and force is false.
        if (!force && localStorage.getItem(key)) {
            return false;
        }
    },
    /**
     * Remove item from local storage by key.
     *
     * @param {String} key
     *   The key of the item that will be deleted.
     * @return {Boolean}
     *   True if deleted, false if there was nothing to delete.
     */
    remove(key) {
        if (localStorage.getItem(key)) {
            localStorage.removeItem(key);
            return true;
        }

        return false;
    },
    /**
     * Get item from localStorage by key.
     *
     * @param {String} key
     *   The key of the item.
     * @return object || null
     */
    get(key) {
        return localStorage.getItem(key);
    }
};
