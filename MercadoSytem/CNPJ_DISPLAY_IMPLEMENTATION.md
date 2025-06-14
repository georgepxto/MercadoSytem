# Exibição de CNPJ na Listagem de Vendedores

## ✅ **IMPLEMENTAÇÃO CONCLUÍDA**

### **Funcionalidade Adicionada**

O CNPJ agora é exibido na aba principal de vendedores junto com as outras informações do vendedor.

### **Onde Aparece**

Na página `/vendors`, cada card de vendedor mostra:

1. **Nome** do vendedor
2. **Email**
3. **Tipo de comida** e status (badges)
4. **Telefone** (com ícone 📞)
5. **CNPJ** (com ícone 🏢) - **NOVO!** - Apenas se o vendedor possuir CNPJ
6. **Descrição** (se existir)
7. **Horários** (se existir)

### **Comportamento**

-   ✅ **Exibição Condicional**: CNPJ só aparece se `has_cnpj = true` E `cnpj` não for vazio
-   ✅ **Ícone Visual**: Usa ícone Bootstrap `bi-building` para representar empresa/CNPJ
-   ✅ **Formatação**: Mostra "CNPJ: XX.XXX.XXX/XXXX-XX"
-   ✅ **Estilo**: Segue o mesmo padrão visual do telefone (texto pequeno e acinzentado)

### **Código Implementado**

```blade
@if($vendor->has_cnpj && $vendor->cnpj)
    <p class="text-muted small mb-2">
        <i class="bi bi-building"></i>
        CNPJ: {{ $vendor->cnpj }}
    </p>
@endif
```

### **Layout Visual**

```
┌─────────────────────────────────────┐
│ [Avatar] Nome do Vendedor           │
│          email@exemplo.com          │
│                                     │
│ [Comida Japonesa] [Ativo]          │
│                                     │
│ 📞 (11) 99999-9999                 │
│ 🏢 CNPJ: 12.345.678/0001-90       │  ← NOVO!
│ Descrição do vendedor...            │
│                                     │
│ Horários:                           │
│ [Segunda] 08:00 - 17:00 Box 1      │
│                                     │
│ [Editar] [Horário] [Excluir]       │
└─────────────────────────────────────┘
```

### **Casos de Teste**

1. ✅ **Vendedor com CNPJ**: Mostra o CNPJ formatado
2. ✅ **Vendedor sem CNPJ**: Não mostra linha do CNPJ
3. ✅ **Vendedor com has_cnpj=true mas cnpj=null**: Não mostra linha do CNPJ

### **Vendedores com CNPJ Atuais**

-   **João Silva CNPJ**: 11.222.333/0001-44
-   **Empresa CNPJ Teste**: 12.345.678/0001-90
-   **Teste CNPJ Backend**: 98.765.432/0001-10

## **Status: ✅ IMPLEMENTADO E FUNCIONANDO**

O CNPJ agora aparece automaticamente na listagem de vendedores quando presente, mantendo a consistência visual com as outras informações do vendedor.
