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

CREATE TABLE StellarClass (Class VARCHAR2(200) PRIMARY KEY, TemperatureRange NUMBER, Colour VARCHAR2(200));
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
CREATE TABLE WrittenIn (PublicationID INT, ResearcherID VARCHAR2(200), ExoplanetName VARCHAR2(200), PRIMARY KEY (PublicationID, ExoplanetName), FOREIGN KEY (PublicationID) REFERENCES Publication(ID) ON DELETE CASCADE, FOREIGN KEY (ExoplanetName) REFERENCES Exoplanet_DiscoveredAt(Name) ON DELETE CASCADE);

INSERT INTO Galaxy(Name, Age, Size, "Distance from milky way (light years)") VALUES 
("Andromeda Galaxy (M31)", 10, 220000, 2.537),
("Triangulum Galaxy (M33)", 13, 60000, 2.73), 
("Whirlpool Galaxy (M51)", 13, 60000, 23), 
("Sombrero Galaxy (M104)", 11, 50000, 29.3), 
("Pinwheel Galaxy (M101)", 13, 170000, 21), 
("Large Magellanic Cloud (LMC)", 13.5, 14000, 0.163), 
("Small Magellanic Cloud (SMC)", 13, 7000, 0.2), 
("Messier 87 (M87)", 13.5, 98000, 53.5),
("Milky Way Galaxy", 13.51, 105700, 0);

INSERT INTO SpaceAgency(Name, Acronym, Region) VALUES 
("National Aeronautics and Space Administration", "NASA", "USA"),
("European Space Agency", "ESA", "Europe"),
("Canadian Space Agency", "CSA", "Canada"),
("Indian Space Research Organisation", "ISRO", "India"),
("Japan Aerospace Exploration Agency", "JAXA", "Japan"),
("French Space Agency", "CNES", "France");

INSERT INTO Publication(ID, Title, PeerReviewed, Citation) VALUES 
(1, "Discovery of Proxima Centauri b", 1, "Smith et al., 2020"),
(2, "Characterizing Kepler-452b", 1, "Johnson & Brown, 2018"),
(3, "Atmospheric Characterization of HD 209458 b Using Hubble Space Telescope", 1, "Garcia et al., 2019"),
(4, "TRAPPIST-1e: A Habitable Exoplanet in the TRAPPIST-1 System", 1, "Chen & Lee, 2021"),
(5, "WASP-1221b: A Neptune-like Exoplanet Orbiting a Sun-like Star", 1, "Wilson & Taylor, 2017"),
(6, "Exploring New Horizons in Exoplanet Research", 0, "Martinez et al., 2019"),
(7, "Advancements in Space Telescope Technology", 1, "Brown & Garcia, 2016"),
(8, "Recent Developments in Planetary Atmosphere Studies", 0, "Jones et al., 2020"),
(9, "Innovations in Space Exploration: Challenges and Opportunities", 1, "Gomez & Wilson, 2018"),
(10, "Frontiers in Exoplanet Detection Methods", 0, "Taylor & Martinez, 2015"),
(11, "The Search for Exoplanets: Past, Present, and Future", 0, "Johnson et al., 2017"),
(12, "Methods for Detecting Exoplanets Using Radial Velocity", 1, "Garcia & Smith, 2018"),
(13, "Exoplanet Atmospheres: Observations and Models", 1, "Brown et al., 2019"),
(14, "Characterization of Exoplanetary Systems", 0, "Wilson & Jones, 2020"),
(15, "Exoplanet Habitability: Conditions and Constraints", 1, "Martinez & Taylor, 2016");

INSERT INTO JournalArticle(PublicationID, DOI) VALUES 
(1, "10.1038/nature19106"),
(2, "10.1126/science.aad8189"),
(3, "10.1088/0004-637X/680/2/1450"),
(4, "10.1126/science.aah6511"),
(5, "10.1093/mnras/stx1287");

INSERT INTO ConferenceProceeding(PublicationID, Location) VALUES 
(6, "Houston, Texas"),
(7, "Cape Town, South Africa"),
(8, "Paris, France"),
(9, "Tokyo, Japan"),
(10, "Sydney, Australia");

INSERT INTO BookChapter(PublicationID, BookName) VALUES 
(11, "Exoplanet Exploration: A Comprehensive Guide"),
(12, "Advances in Exoplanet Research: Techniques and Discoveries"),
(13, "Planetary Science: Recent Advances and Future Directions"),
(14, "The Encyclopedia of Exoplanets"),
(15, "The Handbook of Exoplanetology");

INSERT INTO StellarClass(Class, TemperatureRange, Colour) VALUES 
("O", ">30000", "Blue"),
("B", "10000-30000", "Blue-White"),
("A", "7500-10000", "White"),
("F", "6000-7500", "White-Yellow"),
("G", "5200-6000", "Yellow"),
("K", "3400-4900", "Orange-Red"),
("M", "2100-3400", "Red");

INSERT INTO ExoplanetDimensions(Radius, Mass, Density, Volume) VALUES 
(1.17, 1.1, 0.05465441321, 20.12646254),
(1.6, 1.5, 0.02914214046, 51.47185404),
(1.35, 1.35, 0.04366390757, 30.9179841),
(0.62, 0.92, 0.307187044, 2.994917976),
(0.18, 0.001, 0.01364497112, 0.07328707342);

INSERT INTO SpaceProgram(Name, Objective) VALUES 
("Kepler", "Discover Earth-like planets orbiting other stars."),	
("TESS (Transiting Exoplanet Survey Satellite)", "Search for exoplanets in orbit around the brightest dwarfs in the sky."),
("CHEOPS (CHaracterising ExOPlanet Satellite)", "Characterize known exoplanets orbiting bright stars."),
("James Webb Space Telescope (JWST)", "Study exoplanet atmospheres, formation of stars and galaxies, and more."),
("Hubble Space Telescope", "Exoplanet atmosphere studies, among other astronomical observations."),
("Gaia", "Create a precise three-dimensional map of stars in the Milky Way, aiding in the indirect discovery of exoplanets."),
("PLATO (PLAnetary Transits and Oscillations of stars)", "Detect and characterize a large number of exoplanetary systems, with a focus on discovering and characterizing Earth-sized planets and super-Earths."),
("COROT (Convection, Rotation and planetary Transits)", "The first mission dedicated to the search for exoplanets, it aimed to find Earth-sized planets."),
("ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)", "India's first dedicated multi-wavelength space observatory."),
("NEOSSat (Near-Earth Object Surveillance Satellite)", "Canada's satellite to track asteroids and near-Earth objects.");

INSERT INTO Star_BelongsTo(Name, GalaxyName, Radius,
 Mass, StellarClassClass) VALUES 
("Proxima Centauri", "Milky Way Galaxy", 0.141, 0.123, "M"),
("Kepler-452", "Milky Way Galaxy", 1.11, 1.04, "G"),
("HD 209458", "Milky Way Galaxy", 1.203, 1.148, "G"),
("TRAPPIST-1", "Milky Way Galaxy", 0.1192, 0.0898, "F"),
("WASP-121", "Milky Way Galaxy", 1.458, 1.353, "M");

INSERT INTO Exoplanet_DiscoveredAt(Name, Type, Mass, Radius, "Discovery Year", "Light Years from Earth", "Orbital Period", Eccentricity, SpaceAgencyName, "Discovery Method") VALUES 
("Proxima Centauri b", "Terrestrial", 1.1, 1.17, "2016-08-24", 4.24, 11.2, 0.35, "European Space Agency", "Radial Velocity"),
("Kepler-452b", "Terrestrial", 1.5, 1.6, "2015-07-23", 1402, 384.8, 0, "National Aeronautics and Space Administration", "Transit"),
("HD 209458 b", "Gas Giant", 1.35, 1.35, "1999-11-05", 153, 3.52, 0, "European Space Agency", "Transit"),
("TRAPPIST-1e", "Terrestrial", 0.92, 0.62, "2017-02-22", 39.6, 6.1, 0.08, "National Aeronautics and Space Administration", "Transit"),
("WASP-1221b", "Neptune-like", 0.001, 0.18, "2015-06-02", 880, 1.27, 0, "National Aeronautics and Space Administration", "Transit");

INSERT INTO Researcher_WorksAt(ID, Name, Affiliation, EmailAddress, SpaceAgencyName) VALUES 
("1", "Guillem Anglada-Escudé", "University of London", "anglada@eso.org", "European Space Agency"),
("2", "Michael Mayor", "University of Geneva", "mayor@unige.ch", "European Space Agency"),
("3", "David Charbonneau", "Harvard University", "charbonneau@harvard.edu", "European Space Agency"),
("4", "Timothy M.Brown", "University of Colorado", "tbrown@lco.global", "European Space Agency"),
("5", "Michael Gillon", "University of Liége", "m.gillon@uliege.be", "National Aeronautics and Space Administration"),
("6", "Amaury H.M.J. Triaud", "University of Birmingham", "a.triaud@nasa.gov", "National Aeronautics and Space Administration"),
("7", "Don Pollacco", "University of Warwick", "d.pollacco@warwick.ac.uk", "European Space Agency"),
("8", "Coel Hellier", "Keele University", "c.hellier@keele.ac.uk", "European Space Agency"),
("9", "Charles Bailyn", "Yale University", "charles@yale.edu", "European Space Agency"),
("10", "Jon M. Jenkins", "NASA Ames Research Center", "jon@nasa.gov", "National Aeronautics and Space Administration"),
("11", "Timothy M. Brown", "Las Cumbres Observatory", "timothy@lco.global", "National Aeronautics and Space Administration"),
("12", "Michaël Gillon", "University of Liège", "michael@uliege.be", "National Aeronautics and Space Administration"),
("13", "Laura Kreidberg", "University of California, Santa Cruz", "laura@ucsc.edu", "National Aeronautics and Space Administration");

INSERT INTO DiscoveredBy(ResearcherID, ExoplanetName) VALUES 
("1", "Proxima Centauri b"),
("2", "Proxima Centauri b"),
("3", "HD 209458 b"),
("4", "HD 209458 b"),
("5", "TRAPPIST-1e"),
("6", "TRAPPIST-1e"),
("7", "WASP-1221b"),
("8", "WASP-1221b");

INSERT INTO InitiatedBy(SpaceAgencyName, SpaceProgramName) VALUES 
("National Aeronautics and Space Administration", "Kepler"),
("National Aeronautics and Space Administration", "TESS (Transiting Exoplanet Survey Satellite)"),
("European Space Agency", "CHEOPS (CHaracterising ExOPlanet Satellite)"),
("National Aeronautics and Space Administration", "James Webb Space Telescope (JWST)"),
("National Aeronautics and Space Administration", "Hubble Space Telescope"),
("European Space Agency", "Gaia"),
("European Space Agency", "PLATO (PLAnetary Transits and Oscillations of stars)"),
("European Space Agency", "COROT (Convection, Rotation and planetary Transits)"),
("Indian Space Research Organisation", "ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)"),
("Canadian Space Agency", "NEOSSat (Near-Earth Object Surveillance Satellite)");

INSERT INTO Observatory(SpaceProgramName, Location) VALUES 
("Kepler", "USA"),
("TESS (Transiting Exoplanet Survey Satellite)", "USA"),
("CHEOPS (CHaracterising ExOPlanet Satellite)", "Switzerland"),
("PLATO (PLAnetary Transits and Oscillations of stars)", "France"),
("COROT (Convection, Rotation and planetary Transits)", "France"),
("ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)", "India");

INSERT INTO Mission(SpaceProgramName, LaunchYear, Status) VALUES 
("Kepler", 2009, "Inactive"),
("TESS (Transiting Exoplanet Survey Satellite)", 2018, "Active"),
("CHEOPS (CHaracterising ExOPlanet Satellite)", 2019, "Active"),
("James Webb Space Telescope (JWST)", 2021, "Active"),
("Hubble Space Telescope", 1990, "Active"),
("Gaia", 2013, "Active"),
("PLATO (PLAnetary Transits and Oscillations of stars)", 2026, "Upcoming"),
("COROT (Convection, Rotation and planetary Transits)", 2006, "Inactive"),
("ASTROSAT (not directly exoplanet-focused but significant for astrophysical studies)", 2015, "Active"),
("NEOSSat (Near-Earth Object Surveillance Satellite)", 2013, "Active");

INSERT INTO WrittenBy(PublicationID, ResearcherID) VALUES 
(1, "1"),
(2, "3"),
(3, "8"),
(4, "9"),
(5, "13");

INSERT INTO WrittenIn(PublicationID, ExoplanetName) VALUES
(1, "Proxima Centauri b"),
(2, "Kepler-452b"),
(3, "HD 209458 b"),
(4, "TRAPPIST-1e"),
(5, "WASP-1221b");

INSERT INTO Orbits(ExoplanetName, StarName) VALUES 
("Proxima Centauri b", "Proxima Centauri"),
("Kepler-452b", "Kepler-452"),
("HD 209458 b", "HD 209458"),
("TRAPPIST-1e", "TRAPPIST-1"),
("WASP-1221b", "WASP-121");