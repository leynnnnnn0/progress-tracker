import useAlert from "@/Composables/useAlert.js";

export default function useStore(form, route, model) {
    const { confirm, toast } = useAlert();

    const store = () => {
        return new Promise((resolve) => {
            confirm.require({
                message: `Are you sure you want to create this ${model.toLowerCase()}?`,
                header: "Confirmation",
                icon: "pi pi-exclamation-triangle",
                rejectProps: {
                    label: "Cancel",
                    severity: "secondary",
                    outlined: true,
                },
                acceptProps: {
                    label: "Confirm",
                    severity: "success",
                },
                accept: () => {
                    form.post(route, {
                        onSuccess: () => {
                            toast.add({
                                severity: "success",
                                summary: "Success",
                                detail: `${model} Created Successfully.`,
                                life: 5000,
                            });
                            resolve(true);
                        },
                        onError: (e) => {
                            toast.add({
                                severity: "error",
                                summary: "Error",
                                detail: `An error occured while trying to create an ${model.toLowerCase()}.`,
                                life: 5000,
                            });
                            resolve(false);
                        },
                    });
                },
                reject: () => {
                    resolve(false);
                },
            });
        });
    };

    return {
        store,
    };
}
