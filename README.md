# Exoplanet Exploration System

# Website Link: https://www.students.cs.ubc.ca/~jt3135/project_j9y5w_r1u8j_z0o7k/exoplanet-explorer.php?groupTuplesRequest=&groupTuples=Submit

## Team Members

- Saumya Jain
- Rishavpreet Singh
- Jaiveer Tiwana

## Project Summary

The Exoplanet Exploration System is a project with the objective of constructing a robust SQL database to serve as a repository of comprehensive information regarding exoplanets, their host stars, related space missions, and the research community involved in these explorations. By creating a central platform, the system intends to facilitate advanced queries, cross-referencing, and in-depth analysis, promoting further discoveries in the field of astronomy.

## Domain of Exoplanets

Exoplanets are planets outside our solar system, orbiting around other stars. This domain involves the study of such celestial bodies, their properties, conditions for life, and their potential to hold undiscovered mysteries of our universe. With numerous space missions dedicated to exoplanet research, the field is rich with data waiting to be organized and analyzed.

## Key Features

Our system's architecture demonstrates complex relational design to accommodate the multi-faceted relationships within the exoplanet domain. Key features include:

- **Rich Entity Relationships**: The database consists of 7 concrete entities - Galaxies, Stars, Exoplanets, Space Agencies, Space Programs (with subdivisions for Observatories and Missions), Researchers, and Publications - each with attributes meticulously chosen to capture the essence of the exoplanet domain.
  
- **Complex Relationship Modeling**: Entities are interconnected through a network of relationships that reflect real-world interactions, such as stars belonging to galaxies, exoplanets orbiting stars, and researchers being affiliated with discoveries. This modeling provides a comprehensive understanding of the interconnected nature of celestial research.
  
- **Advanced Attribute Design**: Attributes are designed to capture specific details, such as the temperature range of stars which directly correlates to their stellar class, ensuring data precision for scientific analysis.
  
- **Normalization**: The design adheres to the principles of normalization up to 3NF (Third Normal Form), ensuring data integrity and minimizing redundancy without sacrificing query performance.

- **Participation Constraints**: Rigorous participation and total participation constraints are imposed where necessary, such as every publication must be about some exoplanet, and every space program must be initiated by a space agency, which is pivotal for maintaining data validity.

- **Functional Dependencies**: A set of functional dependencies is defined to ensure that data stored follows a logical consistency, crucial for data quality and reliability.

- **Inclusion of ISA Hierarchies**: ISA hierarchies are utilized to differentiate between various types of Space Programs (Observatories vs. Missions), allowing for polymorphic behavior and simplification of complex relationships.

- **Real-world Data Integration**: The system allows for the inclusion of real-world data from multiple sources, such as space missions, research papers, and observational data, contributing to the richness and utility of the database.

## Use Cases

Researchers, astronomers, and enthusiasts will be able to:

- Query exoplanet characteristics and compare them across different star systems.
- Track the contributions of various space agencies to the field of exoplanet exploration.
- Access a repository of publications related to specific exoplanets, facilitating academic research.
- Evaluate the success and objectives of various space programs and missions dedicated to exoplanet discovery and study.

## Technology Stack

- **Database Management System (DBMS)**: Oracle SQL for robust, scalable data storage and retrieval.
- **Backend**: PHP, chosen for its strong database connectivity capabilities.
- **Frontend**: HTML and CSS for developing a user-friendly interface. (Note: The frontend development is ongoing and subject to evolve with project requirements.)

## Front End
The interface utilizes PHP and Oracle to offer a seamless user experience, enabling users to interact with tables, view newly added exoplanet examples, remove space agencies, modify researcher details, and access various insightful outcomes—all without the need to input any SQL code directly. This responsive website bridges the gap between back-end and front-end operations, ensuring that relevant information is refreshed with each action while delivering immediate feedback on successful transactions and new entries.
