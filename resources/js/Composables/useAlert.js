import { useToast as Toast } from "primevue/usetoast";
import { useConfirm } from "primevue";
export default function useToast() {
    const toast = Toast();
    const confirm = useConfirm();
    return {
        toast,
        confirm,
    };
}
