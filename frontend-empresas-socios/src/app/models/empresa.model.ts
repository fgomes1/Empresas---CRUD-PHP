import { Socio } from './socio.model';

export interface Empresa {
  id: number;
  open?: boolean;
  nome: string;
  socios?: Socio[]; // Define como opcional; use 'socios: Socio[];' se for sempre retornado.
}
