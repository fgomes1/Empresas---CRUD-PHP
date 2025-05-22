import { Component, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-button',
  standalone: true,
  templateUrl: './button.component.html',
  styleUrls: ['./button.component.scss']
})
export class ButtonComponent {
  // Permite configurar o tipo do botão, o rótulo e as classes CSS
  @Input() type: string = 'submit';
  @Input() label: string = 'Acessar';
  @Input() classes: string = 'button button-primary button-large';

  // Emite um evento quando o botão é clicado, se necessário
  @Output() buttonClick = new EventEmitter<Event>();

  onClick(event: Event): void {
    this.buttonClick.emit(event);
  }
}
