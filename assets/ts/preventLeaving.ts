import "ckeditor4";

(() => {

    const form = document.querySelector('form');

    if (!form) {
        return;
    }

    let isDirty = false;

    if (CKEDITOR) {
        for (const key in CKEDITOR.instances) {
            CKEDITOR.instances[key].on('change', () => {
                isDirty = true;
            });
        }
    }

    const handleBeforeUnload = (e: BeforeUnloadEvent) => {
        if (isDirty || formIsDirty()) {
            e.preventDefault();
            return (e.returnValue = 'You have unsaved changes. Are you sure you want to leave?');
        }
        return;
    };

    window.addEventListener('beforeunload', handleBeforeUnload);
    form.addEventListener('submit', () => {
        window.removeEventListener('beforeunload', handleBeforeUnload);
    });

    const initialFormData = new FormData(form);

    const formIsDirty = (): boolean => {
        const initialFormDataValues = [...initialFormData.entries()];
        const currentFormDataValues = [...new FormData(form).entries()];

        if (initialFormDataValues.length !== currentFormDataValues.length) {
            return true;
        }

        for (let i = 0; i < initialFormDataValues.length; i++) {
            if (initialFormDataValues[i][1] !== currentFormDataValues[i][1]) {
                return true;
            }
        }

        return false;
    };

})();
