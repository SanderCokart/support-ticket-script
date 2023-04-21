export default function <T, K extends keyof T>(object: T, keys: K[]) {
    const result: Record<string, any> = {};
    for (let key of keys) {
        result[key as string] = object?.[key];
    }
    return result as Pick<T, K>;
}
