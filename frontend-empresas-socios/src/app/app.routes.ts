import { Routes } from '@angular/router';
import { AppComponent } from './app.component';
import { EmpresaListComponent } from './components/empresa-list/empresa-list.component';

export const routes: Routes = [
   // { path:'', component: AppComponent },
   // { path: '', redirectTo: './', pathMatch: 'full' },
   { path: '', component: EmpresaListComponent },
    // Outras rotas...
  ];
  
