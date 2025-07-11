# Avaliação
Projeto de avaliação dos conhecimentos de desenvolvimento de uma aplicação web. 
Após finalizar, o candidato deve disponibilizar o link do repositório no github.

## Prazo
O candidato terá 3 dias corridos a partir da disponibilização deste arquivo para finalizar o projeto.

## Especificações
* Postgres 14+
* Laravel

## Observações
*Este projeto conta com o ambiente de banco dados já prepardo no docker.*
- Quaisquer configurações ou alterações necessárias para que o projeto seja executado,
devem ser documentadas no projeto

# Objetivo
- Criar um sistema (CRUD) para controle de viagens.
- O Sistema deve conter as seguintes funcionalidades:
* CRUD de Veículos
  * Modelo
  * Ano
  * Data de aquisição
  * KMs rodados no momento da aquisição
  * Renavam - Deve ser único
  * Placa - Deve ser único
* CRUD de Motoristas
  * Nome 
  * Data de nascimento - ter no minímo, 18 anos
  * N° da CNH.
* CRUD de Viagens
  * Escolher os motoristas da viagem
  * Escolher o veículo da viagem
  * KM Inicial do veículo no início da viagem
  * KM Final do veículo ao finalizar a viagem
  * Data e hora inicial da viagem
  * Data e hora de chegada.