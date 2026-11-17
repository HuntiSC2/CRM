%%{init: {'theme': 'base', 'themeVariables': { 'fontFamily': 'Arial', 'fontSize': '12px'}}}%%
flowchart LR

    %% FASE 1: REGISTRO (Separador visual)
    subgraph FASE1 ["--------- FASE 1: REGISTRO ---------"]
        direction TB

        subgraph L1_REQ ["👤 Residente (Requester)"]
            Start(("●<br/>Inicio"))
            T1["Registrar Requerimiento<br/>Básico de Insumos"]
            Start --> T1
        end

    end

    %% FASE 2: EVALUACIÓN (Separador visual)
    subgraph FASE2 ["--------- FASE 2: EVALUACIÓN ---------"]
        direction TB

        subgraph L2_SUP ["👷 Supervisor (Manager 1)"]
            GW1{"+<br/><b>PG 1</b>"}
            T2["Evaluar Metrados<br/>Técnicos en Campo"]
            GW2{"+<br/><b>PG 2</b>"}
            Fin((("■<br/>Fin")))

            GW1 --> T2
            T2 --> GW2
            GW2 --> Fin
        end

        subgraph L3_SIS ["💻 Intranet Laravel (Manager 2)"]
            T3["Validar Disponibilidad<br/>Presupuestal y Stock"]
        end

    end

    %% Conexiones entre Carriles (Bajan y Suben como en Bizagi)
    T1 --> GW1
    GW1 --> T3
    T3 --> GW2

    %% Estilos Bizagi
    style Start fill:#d4edda,stroke:#28a745,stroke-width:2.5px,color:#155724
    style Fin fill:#f8d7da,stroke:#721c24,stroke-width:4px,color:#721c24
    style GW1 fill:#fff3cd,stroke:#ffc107,stroke-width:2px,color:#856404
    style GW2 fill:#fff3cd,stroke:#ffc107,stroke-width:2px,color:#856404
    style T1 fill:#f0f9ff,stroke:#0284c7,stroke-width:1.5px
    style T2 fill:#f0f9ff,stroke:#0284c7,stroke-width:1.5px
    style T3 fill:#f8fafc,stroke:#475569,stroke-width:1.5px
    style FASE1 fill:#ffffff,stroke:#94a3b8,stroke-dasharray: 5 5
    style FASE2 fill:#ffffff,stroke:#94a3b8,stroke-dasharray: 5 5
