import { useToast } from 'primevue/usetoast';

type NotifyContent = string | Record<string, string>;

export function useNotify() {
    const toast = useToast();

    const notify = (severity: 'success' | 'info' | 'warn' | 'error', content: NotifyContent) => {
        let displayMessage = '';

        if (typeof content === 'string') {
            displayMessage = content;
        } else {
            const errorArray = Object.values(content);
            displayMessage = errorArray.length > 0 ? errorArray[0] : 'An unknown error occurred';
        }

        toast.add({
            severity: severity,
            summary: severity.toUpperCase(),
            detail: displayMessage,
            life: 4000,
        });
    };

    return { notify };
}