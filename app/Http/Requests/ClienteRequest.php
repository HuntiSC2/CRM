<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ruc' => [
                'required',
                'digits:11',
                'numeric',
                'regex:/^(10|15|17|20)\d{9}$/', // Valida prefijos estándar de RUC en Perú
                'unique:clientes,ruc',
            ],
            'razon_social' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'nombre_contacto' => 'required|string|max:150',
            'telefono_contacto' => 'required|string|max:20',
            'email_contacto' => 'required|email|max:150',
            'estado' => 'nullable|in:ACTIVO,INACTIVO,EN_EVALUACION',
            'observaciones' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'ruc.required' => 'El número de RUC es obligatorio.',
            'ruc.digits' => 'El RUC debe tener exactamente 11 dígitos.',
            'ruc.numeric' => 'El RUC solo debe contener caracteres numéricos.',
            'ruc.regex' => 'El RUC ingresado no es válido (debe iniciar con 10, 15, 17 o 20).',
            'ruc.unique' => 'Este RUC ya se encuentra registrado en el sistema.',
            'razon_social.required' => 'La razón social es obligatoria.',
            'direccion.max' => 'La dirección no debe superar los 255 caracteres.',
            'nombre_contacto.required' => 'El nombre del contacto es obligatorio.',
            'telefono_contacto.required' => 'El teléfono es obligatorio.',
            'email_contacto.required' => 'El correo electrónico es obligatorio.',
            'email_contacto.email' => 'Ingrese un formato de correo electrónico válido.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }

    /**
     * Retorna JSON HTTP 422 ante fallos de validación en solicitudes AJAX, evitando la redirección.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
