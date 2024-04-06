DROP TABLE Orbits;
DROP TABLE Star_BelongsTo;
DROP TABLE StellarClass;
DROP TABLE Galaxy;
DROP TABLE WrittenBy;
DROP TABLE DiscoveredBy;
DROP TABLE Researcher_WorksAt;
DROP TABLE InitiatedBy;
DROP TABLE WrittenIn;
DROP TABLE Exoplanet_DiscoveredAt;
DROP TABLE SpaceAgency;
DROP TABLE Observatory;
DROP TABLE Mission;
DROP TABLE SpaceProgram;
DROP TABLE JournalArticle;
DROP TABLE ConferenceProceeding;
DROP TABLE BookChapter;
DROP TABLE Publication;
DROP TABLE ExoplanetDimensions;

CREATE TABLE StellarClass (Class VARCHAR2(200) PRIMARY KEY, TemperatureRange VARCHAR2(200), Colour VARCHAR2(200));
CREATE TABLE Galaxy(Name VARCHAR2(200) PRIMARY KEY, Age NUMBER, Size_T NUMBER, "Distance from milky way" NUMBER);
CREATE TABLE Star_BelongsTo (Name VARCHAR2(200) PRIMARY KEY, GalaxyName VARCHAR2(200) NOT NULL, Radius NUMBER, Mass NUMBER, StellarClassClass VARCHAR2(200), FOREIGN KEY (GalaxyName) REFERENCES Galaxy(Name) ON DELETE CASCADE, FOREIGN KEY (StellarClassClass) REFERENCES StellarClass(Class) ON DELETE CASCADE);
CREATE TABLE SpaceAgency (Name VARCHAR2(200) PRIMARY KEY, Acronym CHAR(100), Region VARCHAR2(200));
CREATE TABLE SpaceProgram (Name VARCHAR2(200) PRIMARY KEY, Objective VARCHAR2(200));
CREATE TABLE Observatory (SpaceProgramName VARCHAR2(200) PRIMARY KEY, Location VARCHAR2(200), FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name) ON DELETE CASCADE);
CREATE TABLE Mission (SpaceProgramName VARCHAR2(200) PRIMARY KEY, LaunchYear INT, Status VARCHAR2(200), FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name) ON DELETE CASCADE);
CREATE TABLE Publication (ID INT PRIMARY KEY, Title VARCHAR2(200) NOT NULL, PeerReviewed NUMBER(1), Citation VARCHAR2(200) UNIQUE);
CREATE TABLE JournalArticle (PublicationID INT PRIMARY KEY, DOI VARCHAR2(200), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE);
CREATE TABLE ConferenceProceeding (PublicationID INT PRIMARY KEY, Location VARCHAR2(200), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE);
CREATE TABLE BookChapter (PublicationID INT PRIMARY KEY, BookName VARCHAR2(200), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE);
CREATE TABLE ExoplanetDimensions (Radius NUMBER, Mass NUMBER, Density NUMBER, Volume NUMBER, PRIMARY KEY (Radius, Mass));
CREATE TABLE Researcher_WorksAt (ID VARCHAR2(200) PRIMARY KEY, Name VARCHAR2(200), Affiliation VARCHAR2(200), EmailAddress VARCHAR2(200) UNIQUE, SpaceAgencyName VARCHAR2(200), FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name) ON DELETE CASCADE);
CREATE TABLE InitiatedBy (SpaceAgencyName VARCHAR2(200), SpaceProgramName VARCHAR2(200), PRIMARY KEY (SpaceAgencyName, SpaceProgramName), FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name) ON DELETE CASCADE, FOREIGN KEY (SpaceProgramName) REFERENCES SpaceProgram(Name) ON DELETE CASCADE);
CREATE TABLE WrittenBy (PublicationID INT, ResearcherID VARCHAR2(200), PRIMARY KEY (PublicationID, ResearcherID), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE, FOREIGN KEY (ResearcherID) REFERENCES Researcher_WorksAt(ID) ON DELETE CASCADE);
CREATE TABLE Exoplanet_DiscoveredAt (Name VARCHAR2(200) PRIMARY KEY, Type VARCHAR2(200), Mass NUMBER, Radius NUMBER, "Discovery Year" INT, "Light Years from Earth" NUMBER, "Orbital Period" NUMBER, Eccentricity NUMBER, SpaceAgencyName VARCHAR2(200), "Discovery Method" VARCHAR2(200), FOREIGN KEY (SpaceAgencyName) REFERENCES SpaceAgency(Name) ON DELETE CASCADE, FOREIGN KEY (Mass, Radius) REFERENCES ExoplanetDimensions(Mass, Radius) ON DELETE CASCADE);
CREATE TABLE DiscoveredBy (ResearcherID VARCHAR2(200), ExoplanetName VARCHAR2(200), PRIMARY KEY (ResearcherID, ExoplanetName), FOREIGN KEY (ResearcherID) REFERENCES Researcher_WorksAt(ID) ON DELETE CASCADE, FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name) ON DELETE CASCADE);
CREATE TABLE Orbits (ExoplanetName VARCHAR2(200), StarName VARCHAR2(200), PRIMARY KEY (ExoplanetName, StarName), FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name) ON DELETE CASCADE, FOREIGN KEY (StarName) REFERENCES Star_BelongsTo(Name) ON DELETE CASCADE);
CREATE TABLE WrittenIn (PublicationID INT, ExoplanetName VARCHAR2(200), PRIMARY KEY (PublicationID, ExoplanetName), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE, FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name) ON DELETE CASCADE);

INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Andromeda Galaxy (M31)', 10, 220000, 2.537);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Triangulum Galaxy (M33)', 13, 60000, 2.73);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Whirlpool Galaxy (M51)', 13, 60000, 23);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Sombrero Galaxy (M104)', 11, 50000, 29.3);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Pinwheel Galaxy (M101)', 13, 170000, 21);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Large Magellanic Cloud (LMC)', 13.5, 14000, 0.163);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Small Magellanic Cloud (SMC)', 13, 7000, 0.2);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Messier 87 (M87)', 13.5, 98000, 53.5);
INSERT INTO Galaxy(Name, Age, Size_T, "Distance from milky way") VALUES ('Milky Way Galaxy', 13.51, 105700, 0);

INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('National Aeronautics and Space Administration', 'NASA', 'USA');
INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('European Space Agency', 'ESA', 'Europe');
INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Canadian Space Agency', 'CSA', 'Canada');
INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Indian Space Research Organisation', 'ISRO', 'India');
INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('Japan Aerospace Exploration Agency', 'JAXA', 'Japan');
INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES ('French Space Agency', 'CNES', 'France');

INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (1, 'Discovery of Proxima Centauri b', 1, 'Smith et al., 2020');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (2, 'Characterizing Kepler-452b', 1, 'Johnson & Brown, 2018');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (3, 'Atmospheric Characterization of HD 209458 b Using Hubble Space Telescope', 1, 'Garcia et al., 2019');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (4, 'TRAPPIST-1e: A Habitable Exoplanet in the TRAPPIST-1 System', 1, 'Chen & Lee, 2021');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (5, 'WASP-1221b: A Neptune-like Exoplanet Orbiting a Sun-like Star', 1, 'Wilson & Taylor, 2017');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (6, 'Exploring New Horizons in Exoplanet Research', 0, 'Martinez et al., 2019');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (7, 'Advancements in Space Telescope Technology', 1, 'Brown & Garcia, 2016');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (8, 'Recent Developments in Planetary Atmosphere Studies', 0, 'Jones et al., 2020');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (9, 'Innovations in Space Exploration: Challenges and Opportunities', 1, 'Gomez & Wilson, 2018');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (10, 'Frontiers in Exoplanet Detection Methods', 0, 'Taylor & Martinez, 2015');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (11, 'The Search for Exoplanets: Past, Present, and Future', 0, 'Johnson et al., 2017');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (12, 'Methods for Detecting Exoplanets Using Radial Velocity', 1, 'Garcia & Smith, 2018');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (13, 'Exoplanet Atmospheres: Observations and Models', 1, 'Brown et al., 2019');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (14, 'Characterization of Exoplanetary Systems', 0, 'Wilson & Jones, 2020');
INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES (15, 'Exoplanet Habitability: Conditions and Constraints', 1, 'Martinez & Taylor, 2016');

INSERT INTO JournalArticle(PublicationID, DOI) VALUES (1, '10.1038/nature19106');
INSERT INTO JournalArticle(PublicationID, DOI) VALUES (2, '10.1126/science.aad8189');
INSERT INTO JournalArticle(PublicationID, DOI) VALUES (3, '10.1088/0004-637X/680/2/1450');
INSERT INTO JournalArticle(PublicationID, DOI) VALUES (4, '10.1126/science.aah6511');
INSERT INTO JournalArticle(PublicationID, DOI) VALUES (5, '10.1093/mnras/stx1287');

INSERT INTO ConferenceProceeding(PublicationID, Location) VALUES (6, 'Houston, Texas');
INSERT INTO ConferenceProceeding(PublicationID, Location) VALUES (7, 'Cape Town, South Africa');
INSERT INTO ConferenceProceeding(PublicationID, Location) VALUES (8, 'Paris, France');
INSERT INTO ConferenceProceeding(PublicationID, Location) VALUES (9, 'Tokyo, Japan');
INSERT INTO ConferenceProceeding(PublicationID, Location) VALUES (10, 'Sydney, Australia');

INSERT INTO BookChapter(PublicationID, BookName) VALUES (11, 'Exoplanet Exploration: A Comprehensive Guide');
INSERT INTO BookChapter(PublicationID, BookName) VALUES (12, 'Advances in Exoplanet Research: Techniques and Discoveries');
INSERT INTO BookChapter(PublicationID, BookName) VALUES (13, 'Planetary Science: Recent Advances and Future Directions');
INSERT INTO BookChapter(PublicationID, BookName) VALUES (14, 'The Encyclopedia of Exoplanets');
INSERT INTO BookChapter(PublicationID, BookName) VALUES (15, 'The Handbook of Exoplanetology');


INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES ('O', '>30000', 'Blue');
INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES ('B', '10000-30000', 'Blue-White');
INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES ('A', '7500-10000', 'White');
INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES ('F', '6000-7500', 'White-Yellow');
INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES ('G', '5200-6000', 'Yellow');
INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES ('K', '3400-4900', 'Orange-Red');
INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES ('M', '2100-3400', 'Red');

INSERT INTO ExoplanetDimensions(Radius, Mass, Density, Volume) VALUES (1.17, 1.1, 0.05465441321, 20.12646254);
INSERT INTO ExoplanetDimensions(Radius, Mass, Density, Volume) VALUES (1.6, 1.5, 0.02914214046, 51.47185404);
INSERT INTO ExoplanetDimensions(Radius, Mass, Density, Volume) VALUES (1.35, 1.35, 0.04366390757, 30.9179841);
INSERT INTO ExoplanetDimensions(Radius, Mass, Density, Volume) VALUES (0.62, 0.92, 0.307187044, 2.994917976);
INSERT INTO ExoplanetDimensions(Radius, Mass, Density, Volume) VALUES (0.18, 0.001, 0.01364497112, 0.07328707342);

INSERT INTO SpaceProgram(Name, Objective) VALUES ('Kepler', 'Discover Earth-like planets orbiting other stars.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('TESS (Transiting Exoplanet Survey Satellite)', 'Search for exoplanets in orbit around the brightest dwarfs in the sky.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('CHEOPS (CHaracterising ExOPlanet Satellite)', 'Characterize known exoplanets orbiting bright stars.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('James Webb Space Telescope (JWST)', 'Study exoplanet atmospheres, formation of stars and galaxies, and more.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('Hubble Space Telescope', 'Exoplanet atmosphere studies, among other astronomical observations.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('Gaia', 'Create a precise three-dimensional map of stars in the Milky Way, aiding in the indirect discovery of exoplanets.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('PLATO (PLAnetary Transits and Oscillations of stars)', 'Detect and characterize a large number of exoplanetary systems, with a focus on discovering and characterizing Earth-sized planets and super-Earths.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('COROT (Convection, Rotation and planetary Transits)', 'The first mission dedicated to the search for exoplanets, it aimed to find Earth-sized planets.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)', 'First dedicated multi-wavelength space observatory by India.');
INSERT INTO SpaceProgram(Name, Objective) VALUES ('NEOSSat (Near-Earth Object Surveillance Satellite)', 'Satellite to track asteroids and near-Earth objects from Canada.');

INSERT INTO Star_BelongsTo(Name, GalaxyName, Radius, Mass, StellarClassClass) VALUES ('Proxima Centauri', 'Milky Way Galaxy', 0.141, 0.123, 'M');
INSERT INTO Star_BelongsTo(Name, GalaxyName, Radius, Mass, StellarClassClass) VALUES ('Kepler-452', 'Milky Way Galaxy', 1.11, 1.04, 'G');
INSERT INTO Star_BelongsTo(Name, GalaxyName, Radius, Mass, StellarClassClass) VALUES ('HD 209458', 'Milky Way Galaxy', 1.203, 1.148, 'G');
INSERT INTO Star_BelongsTo(Name, GalaxyName, Radius, Mass, StellarClassClass) VALUES ('TRAPPIST-1', 'Milky Way Galaxy', 0.1192, 0.0898, 'F');
INSERT INTO Star_BelongsTo(Name, GalaxyName, Radius, Mass, StellarClassClass) VALUES ('WASP-121', 'Milky Way Galaxy', 1.458, 1.353, 'M');

INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, "Discovery Year", "Light Years from Earth", "Orbital Period", Eccentricity, SpaceAgencyName, "Discovery Method") VALUES ('Proxima Centauri b', 'Terrestrial', 1.1, 1.17, 2016, 4.24, 11.2, 0.35, 'European Space Agency', 'Radial Velocity');
INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, "Discovery Year", "Light Years from Earth", "Orbital Period", Eccentricity, SpaceAgencyName, "Discovery Method") VALUES ('Kepler-452b', 'Terrestrial', 1.5, 1.6, 2015, 1402, 384.8, 0, 'National Aeronautics and Space Administration', 'Transit');
INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, "Discovery Year", "Light Years from Earth", "Orbital Period", Eccentricity, SpaceAgencyName, "Discovery Method") VALUES ('HD 209458 b', 'Gas Giant', 1.35, 1.35, 1999, 153, 3.52, 0, 'European Space Agency', 'Transit');
INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, "Discovery Year", "Light Years from Earth", "Orbital Period", Eccentricity, SpaceAgencyName, "Discovery Method") VALUES ('TRAPPIST-1e', 'Terrestrial', 0.92, 0.62, 2017, 39.6, 6.1, 0.08, 'National Aeronautics and Space Administration', 'Transit');
INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, "Discovery Year", "Light Years from Earth", "Orbital Period", Eccentricity, SpaceAgencyName, "Discovery Method") VALUES ('WASP-1221b', 'Neptune-like', 0.001, 0.18, 2015, 880, 1.27, 0, 'National Aeronautics and Space Administration', 'Transit');

INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('1', 'Guillem Anglada-Escudé', 'University of London', 'anglada@eso.org', 'European Space Agency');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('2', 'Michael Mayor', 'University of Geneva', 'mayor@unige.ch', 'European Space Agency');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('3', 'David Charbonneau', 'Harvard University', 'charbonneau@harvard.edu', 'European Space Agency');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('4', 'Timothy M.Brown', 'University of Colorado', 'tbrown@lco.global', 'European Space Agency');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('5', 'Michael Gillon', 'University of Liége', 'm.gillon@uliege.be', 'National Aeronautics and Space Administration');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('6', 'Amaury H.M.J. Triaud', 'University of Birmingham', 'a.triaud@nasa.gov', 'National Aeronautics and Space Administration');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('7', 'Don Pollacco', 'University of Warwick', 'd.pollacco@warwick.ac.uk', 'European Space Agency');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('8', 'Coel Hellier', 'Keele University', 'c.hellier@keele.ac.uk', 'European Space Agency');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('9', 'Charles Bailyn', 'Yale University', 'charles@yale.edu', 'European Space Agency');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('10', 'Jon M. Jenkins', 'NASA Ames Research Center', 'jon@nasa.gov', 'National Aeronautics and Space Administration');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('11', 'Timothy M. Brown', 'Las Cumbres Observatory', 'timothy@lco.global', 'National Aeronautics and Space Administration');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('12', 'Michaël Gillon', 'University of Liège', 'michael@uliege.be', 'National Aeronautics and Space Administration');
INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES ('13', 'Laura Kreidberg', 'University of California, Santa Cruz', 'laura@ucsc.edu', 'National Aeronautics and Space Administration');

INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('1', 'Proxima Centauri b');
INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('2', 'Proxima Centauri b');
INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('3', 'HD 209458 b');
INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('4', 'HD 209458 b');
INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('5', 'TRAPPIST-1e');
INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('6', 'TRAPPIST-1e');
INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('7', 'WASP-1221b');
INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES ('8', 'WASP-1221b');

INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('National Aeronautics and Space Administration', 'Kepler');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('National Aeronautics and Space Administration', 'TESS (Transiting Exoplanet Survey Satellite)');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('European Space Agency', 'CHEOPS (CHaracterising ExOPlanet Satellite)');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('National Aeronautics and Space Administration', 'James Webb Space Telescope (JWST)');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('National Aeronautics and Space Administration', 'Hubble Space Telescope');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('European Space Agency', 'Gaia');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('European Space Agency', 'PLATO (PLAnetary Transits and Oscillations of stars)');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('European Space Agency', 'COROT (Convection, Rotation and planetary Transits)');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('Indian Space Research Organisation', 'ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)');
INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES ('Canadian Space Agency', 'NEOSSat (Near-Earth Object Surveillance Satellite)');

INSERT INTO Observatory(SpaceProgramName, Location) VALUES ('Kepler', 'USA');
INSERT INTO Observatory(SpaceProgramName, Location) VALUES ('TESS (Transiting Exoplanet Survey Satellite)', 'USA');
INSERT INTO Observatory(SpaceProgramName, Location) VALUES ('CHEOPS (CHaracterising ExOPlanet Satellite)', 'Switzerland');
INSERT INTO Observatory(SpaceProgramName, Location) VALUES ('PLATO (PLAnetary Transits and Oscillations of stars)', 'France');
INSERT INTO Observatory(SpaceProgramName, Location) VALUES ('COROT (Convection, Rotation and planetary Transits)', 'France');
INSERT INTO Observatory(SpaceProgramName, Location) VALUES ('ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)', 'India');

INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('Kepler', 2009, 'Inactive');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('TESS (Transiting Exoplanet Survey Satellite)', 2018, 'Active');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('CHEOPS (CHaracterising ExOPlanet Satellite)', 2019, 'Active');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('James Webb Space Telescope (JWST)', 2021, 'Active');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('Hubble Space Telescope', 1990, 'Active');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('Gaia', 2013, 'Active');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('PLATO (PLAnetary Transits and Oscillations of stars)', 2026, 'Upcoming');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('COROT (Convection, Rotation and planetary Transits)', 2006, 'Inactive');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)', 2015, 'Active');
INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES ('NEOSSat (Near-Earth Object Surveillance Satellite)', 2013, 'Active');

INSERT INTO WrittenBy(PublicationID, ResearcherID) VALUES (1, '1');
INSERT INTO WrittenBy(PublicationID, ResearcherID) VALUES (2, '3');
INSERT INTO WrittenBy(PublicationID, ResearcherID) VALUES (3, '8');
INSERT INTO WrittenBy(PublicationID, ResearcherID) VALUES (4, '9');
INSERT INTO WrittenBy(PublicationID, ResearcherID) VALUES (5, '13');

INSERT INTO WrittenIn(PublicationID, ExoplanetName) VALUES (1, 'Proxima Centauri b');
INSERT INTO WrittenIn(PublicationID, ExoplanetName) VALUES (2, 'Kepler-452b');
INSERT INTO WrittenIn(PublicationID, ExoplanetName) VALUES (3, 'HD 209458 b');
INSERT INTO WrittenIn(PublicationID, ExoplanetName) VALUES (4, 'TRAPPIST-1e');
INSERT INTO WrittenIn(PublicationID, ExoplanetName) VALUES (5, 'WASP-1221b');

INSERT INTO Orbits(ExoplanetName, StarName) VALUES ('Proxima Centauri b', 'Proxima Centauri');
INSERT INTO Orbits(ExoplanetName, StarName) VALUES ('Kepler-452b', 'Kepler-452');
INSERT INTO Orbits(ExoplanetName, StarName) VALUES ('HD 209458 b', 'HD 209458');
INSERT INTO Orbits(ExoplanetName, StarName) VALUES ('TRAPPIST-1e', 'TRAPPIST-1');
INSERT INTO Orbits(ExoplanetName, StarName) VALUES ('WASP-1221b', 'WASP-121');