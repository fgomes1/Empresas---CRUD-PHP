import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateSocioModalComponent } from './create-socio-modal.component';

describe('CreateSocioModalComponent', () => {
  let component: CreateSocioModalComponent;
  let fixture: ComponentFixture<CreateSocioModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CreateSocioModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CreateSocioModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
