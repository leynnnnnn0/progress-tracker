import useAlert from "@/Composables/useAlert.js";

export default function useUpdate(form, getRoute, model) {
    const { confirm, toast } = useAlert();

    const update = () => {
        const currentRoute =
            typeof getRoute === "function" ? getRoute() : getRoute;

        return new Promise((resolve) => {
            confirm.require({
                message: `Are you sure you want to update this ${model.toLowerCase()}?`,
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
                    form.put(currentRoute, {
                        onSuccess: () => {
                            toast.add({
                                severity: "success",
                                summary: "Success",
                                detail: `${model} Updated Successfully.`,
                                life: 5000,
                            });
                            resolve(true);
                            return true;
                        },
                        onError: (e) => {
                            console.log(e);
                            toast.add({
                                severity: "error",
                                summary: "Error",
                                detail: `An error occured while trying to update the ${model.toLowerCase()} details.`,
                                life: 5000,
                            });
                            resolve(false);
                            return false;
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
        update,
    };
}
