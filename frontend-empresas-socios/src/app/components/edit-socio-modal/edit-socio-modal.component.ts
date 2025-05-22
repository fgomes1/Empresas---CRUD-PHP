// src/app/components/edit-socio-modal/edit-socio-modal.component.ts
import { Component, EventEmitter, Input, OnChanges, Output, SimpleChanges } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormGroup, FormControl, Validators } from '@angular/forms';
import { Socio } from '../../models/socio.model';

@Component({
  selector: 'app-edit-socio-modal',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './edit-socio-modal.component.html',
  styleUrls: ['./edit-socio-modal.component.scss']
})
export class EditSocioModalComponent implements OnChanges {
  // Recebe o sócio a ser editado; se for nulo, não há nada para editar.
  @Input() socio: Socio | null = null;
  // Emite um evento para fechar o modal.
  @Output() closeModal = new EventEmitter<void>();
  // Emite os dados atualizados do sócio.
  @Output() socioUpdated = new EventEmitter<Socio>();

  // Formulário reativo com o campo 'nome' (adicione outros campos se necessário)
  editForm: FormGroup = new FormGroup({
    nome: new FormControl('', Validators.required)
  });

  // Quando o Input 'socio' muda, atualiza o formulário com os dados do sócio.
  ngOnChanges(changes: SimpleChanges): void {
    if (changes['socio'] && this.socio) {
      this.editForm.patchValue({
        nome: this.socio.nome
      });
    }
  }

  // Quando o formulário é submetido, verifica se é válido, emite o evento com os dados atualizados e fecha o modal.
  onSubmit(): void {
    if (this.editForm.valid && this.socio) {
      const updatedSocio: Socio = { ...this.socio, ...this.editForm.value };
      this.socioUpdated.emit(updatedSocio);
      this.closeModal.emit();
    }
  }

  // Método para cancelar a edição e fechar o modal.
  onCancel(): void {
    this.closeModal.emit();
  }
}
