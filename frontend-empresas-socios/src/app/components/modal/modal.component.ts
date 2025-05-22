import { Component, EventEmitter, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormGroup, FormControl, Validators } from '@angular/forms';

@Component({
  selector: 'app-create-company-modal',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './modal.component.html',
  styleUrls: ['./modal.component.scss']
})
export class CreateCompanyModalComponent {
  // Emite evento para fechar o modal após criar ou cancelar
  @Output() closeModal = new EventEmitter<void>();
  @Output() companyCreated = new EventEmitter<any>();

  companyForm = new FormGroup({
    nome: new FormControl('', [Validators.required]),
    // adicione outros campos conforme necessário
  });

  onSubmit(): void {
    if (this.companyForm.valid) {
      // Emite o objeto empresa para o componente pai
      this.companyCreated.emit(this.companyForm.value);
      // Fecha o modal
      this.closeModal.emit();
    }
  }

  onCancel(): void {
    // Apenas fecha o modal sem criar nada
    this.closeModal.emit();
  }
}
