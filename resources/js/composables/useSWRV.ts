import {useAxios} from '@/plugins/axios';
import useSWRV from 'swrv';
import type {IKey, IConfig, IResponse} from 'swrv/dist/types';

function UseSWRV<Data = any, Error = any>(key: IKey, config?: IConfig): IResponse<Data, Error> {
    const axios = useAxios();
    return useSWRV(key, args => axios.simpleGet(args).then(res => res.data), config);
}

export default UseSWRV;
