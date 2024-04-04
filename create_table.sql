CREATE TABLE Galaxy(
    Name VARCHAR[200] PRIMARY KEY,
    Age BIGINT,
    Size BIGINT,
    "Distance from milky way (light years)" DOUBLE
);

CREATE TABLE Star_BelongsTo (
    Name VARCHAR PRIMARY KEY,
    GalaxyName VARCHAR[200] NOT NULL,
    Radius DOUBLE,
    Mass DOUBLE,
    StellarClassClass VARCHAR[200],
    FOREIGN KEY (GalaxyName) REFERENCES Galaxy(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (StellarClassClass) REFERENCES StellarClass(Class)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Orbits (
    ExoplanetName VARCHAR[200],
    StarName VARCHAR[200],
    PRIMARY KEY (ExoplanetName, StarName),
    FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (StarName) REFERENCES Star_BelongsTo(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Exoplanet_DiscoveredAt (
    Name VARCHAR[200] PRIMARY KEY,
    Type VARCHAR[200],
    Mass DOUBLE,
    Radius DOUBLE,
    "Discovery Year" INT,
    "Light Years from Earth"   DOUBLE,
    "Orbital Period" DOUBLE,
    Eccentricity DOUBLE,
    SpaceAgencyName VARCHAR[200],
    "Discovery Method" VARCHAR[200],
    FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
    FOREIGN KEY (Mass, Radius) REFERENCES ExoplanetDimensions(Mass, Radius)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Researcher_WorksAt (
    ID VARCHAR[200] PRIMARY KEY,
    Name VARCHAR[200],
    Affiliation VARCHAR[200],
    EmailAddress VARCHAR[200] UNIQUE,
   SpaceAgencyName VARCHAR[200],
    FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE DiscoveredBy (
    ResearcherID VARCHAR[200],
    ExoplanetName VARCHAR[200],
    PRIMARY KEY (ResearcherID, ExoplanetName),
    FOREIGN KEY (ResearcherID) REFERENCES Researcher_WorksAt(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE SpaceAgency (
    Name VARCHAR[200] PRIMARY KEY,
    Acronym CHAR(100),
    Region VARCHAR[200]
);

CREATE TABLE SpaceProgram (
    Name VARCHAR[200] PRIMARY KEY,
    Objective VARCHAR[200]
);

CREATE TABLE InitiatedBy (
    SpaceAgencyName VARCHAR[200],
    SpaceProgramName VARCHAR[200],
    PRIMARY KEY (SpaceAgencyName, SpaceProgramName),
    FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Observatory (
    SpaceProgramName VARCHAR[200] PRIMARY KEY,
    Location VARCHAR[200],
    FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Mission (
    SpaceProgramName VARCHAR[200] PRIMARY KEY,
    LaunchYear INT,
    Status VARCHAR[200],
    FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Publication (
    ID INT PRIMARY KEY,
    Title VARCHAR[200] NOT NULL,
    PeerReviewed BOOLEAN,
    Citation VARCHAR[200] UNIQUE
);

CREATE TABLE JournalArticle (
    PublicationID INT PRIMARY KEY,
    DOI VARCHAR[200],
    FOREIGN KEY (PublicationID) REFERENCES Publication(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE ConferenceProceeding (
    PublicationID INT PRIMARY KEY,
    Location VARCHAR[200],
    FOREIGN KEY (PublicationID) REFERENCES Publication(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE BookChapter (
    PublicationID INT PRIMARY KEY,
    BookName VARCHAR[200],
    FOREIGN KEY (PublicationID) REFERENCES Publication(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE WrittenIn (
    PublicationID INT,
    ResearcherID VARCHAR[200],
    PRIMARY KEY (PublicationID, ResearcherID),
    FOREIGN KEY (PublicationID) REFERENCES Publication(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (ResearcherID) REFERENCES Researcher_WorksAt(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE StellarClass (
    Class VARCHAR[200] PRIMARY KEY,
    TemperatureRange INT,
    Colour VARCHAR[200]
);

CREATE TABLE ExoplanetDimensions (
    Radius DOUBLE,
    Mass DOUBLE,
    Density DOUBLE,
    Volume DOUBLE,
    PRIMARY KEY (Radius, Mass));
