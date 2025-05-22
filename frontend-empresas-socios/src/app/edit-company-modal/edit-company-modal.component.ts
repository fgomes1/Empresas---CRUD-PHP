import { Component, EventEmitter, Input, OnChanges, Output, SimpleChanges } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormGroup, FormControl, Validators } from '@angular/forms';

@Component({
  selector: 'app-edit-company-modal',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './edit-company-modal.component.html',
  styleUrls: ['./edit-company-modal.component.scss']
})
export class EditCompanyModalComponent implements OnChanges {
  // Recebe a empresa que será editada do componente pai
  @Input() company: { id: number; nome: string } | null = null;
  @Output() closeModal = new EventEmitter<void>();
  @Output() companyUpdated = new EventEmitter<{ id: number; nome: string }>();

  editForm: FormGroup = new FormGroup({
    nome: new FormControl('', [Validators.required])
  });

  // Atualiza o formulário quando a propriedade 'company' muda
  ngOnChanges(changes: SimpleChanges): void {
    if (changes['company'] && this.company) {
      this.editForm.patchValue({
        nome: this.company.nome
      });
    }
  }

  // Submete o formulário, emite o evento com a empresa atualizada e fecha o modal
  onSubmit(): void {
    if (this.editForm.valid && this.company) {
      const updatedCompany = { ...this.company, ...this.editForm.value };
      this.companyUpdated.emit(updatedCompany);
      this.closeModal.emit();
    }
  }

  // Fecha o modal sem atualizar
  onCancel(): void {
    this.closeModal.emit();
  }
}
