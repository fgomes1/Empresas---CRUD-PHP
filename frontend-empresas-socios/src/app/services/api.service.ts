import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Empresa } from '../models/empresa.model';
import { Socio } from '../models/socio.model';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private baseUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) { }

  // Empresas
  getEmpresas(): Observable<Empresa[]> {
    return this.http.get<Empresa[]>(`${this.baseUrl}/empresas`);
  }

  getEmpresa(id: number): Observable<Empresa> {
    return this.http.get<Empresa>(`${this.baseUrl}/empresas/${id}`);
  }

  createEmpresa(empresa: Empresa): Observable<Empresa> {
    return this.http.post<Empresa>(`${this.baseUrl}/empresas`, empresa);
  }

  updateEmpresa(id: number, empresa: Empresa): Observable<Empresa> {
    return this.http.put<Empresa>(`${this.baseUrl}/empresas/${id}`, empresa);
  }

  deleteEmpresa(id: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/empresas/${id}`);
  }

  // Sócios
  getSocios(empresaId: number): Observable<Socio[]> {
    return this.http.get<Socio[]>(`${this.baseUrl}/empresas/${empresaId}/socios`);
  }
  

  getSocio(empresaId: number, socioId: number): Observable<Socio> {
    return this.http.get<Socio>(`${this.baseUrl}/empresas/${empresaId}/socios/${socioId}`);
  }

  
  createSocio(empresaId: number, socio: Socio): Observable<Socio> {
    return this.http.post<Socio>(`${this.baseUrl}/empresas/${empresaId}/socios`, socio);
  }

  updateSocio(empresaId: number, socioId: number, socio: Socio): Observable<Socio> {
    return this.http.put<Socio>(`${this.baseUrl}/empresas/${empresaId}/socios/${socioId}`, socio);
  }

  deleteSocio(empresaId: number, socioId: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/empresas/${empresaId}/socios/${socioId}`);
  }
}
