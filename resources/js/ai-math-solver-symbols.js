export const SCIENCE_BRANCHES = [
  { id: "math", label: "📐 Mathematics", color: "hover:bg-indigo-50 border-indigo-200 text-indigo-700" },
  { id: "physics", label: "⚡ Physics", color: "hover:bg-amber-50 border-amber-200 text-amber-700" },
  { id: "chemistry", label: "🧪 Chemistry", color: "hover:bg-emerald-50 border-emerald-200 text-emerald-700" },
  { id: "biology", label: "🧬 Biology", color: "hover:bg-rose-50 border-rose-200 text-rose-700" },
  { id: "astrophysics", label: "🚀 NASA / Astro", color: "hover:bg-sky-50 border-sky-200 text-sky-700" },
  { id: "finance", label: "💼 Finance / CA", color: "hover:bg-green-50 border-green-200 text-green-700" }
];

export const SYMBOLS_DATA = {
  math: [
    // Calculus & Limits
    { label: "∫", value: "∫ ", description: "Definite/indefinite integral symbol", category: "Calculus & Analysis" },
    { label: "∬", value: "∬ ", description: "Double volume/surface integral symbol", category: "Calculus & Analysis" },
    { label: "∮", value: "∮ ", description: "Closed path/contour integral", category: "Calculus & Analysis" },
    { label: "d/dx", value: "d/dx ", description: "Leibniz derivative with respect to x", category: "Calculus & Analysis" },
    { label: "dy/dx", value: "dy/dx", description: "Leibniz derivative notation", category: "Calculus & Analysis" },
    { label: "lim", value: "lim_{x -> 0} ", description: "Functional limit evaluation", category: "Calculus & Analysis" },
    { label: "Σ", value: "Σ ", description: "Summation (Sigma operator)", category: "Calculus & Analysis" },
    { label: "∏", value: "∏ ", description: "Product (Capital pi operator)", category: "Calculus & Analysis" },
    { label: "∂", value: "∂", description: "Partial derivative curly d", category: "Calculus & Analysis" },
    { label: "Δ", value: "Δ", description: "Delta (change of or laplacian)", category: "Calculus & Analysis" },
    { label: "∇", value: "∇", description: "Nabla (gradient vector differential)", category: "Calculus & Analysis" },
    { label: "∞", value: "∞", description: "Infinity mathematical symbol", category: "Calculus & Analysis" },
    
    // Algebra & powers
    { label: "x", value: "x", description: "Independent variable x", category: "Algebra & Variables" },
    { label: "y", value: "y", description: "Dependent variable y", category: "Algebra & Variables" },
    { label: "z", value: "z", description: "Independent variable z", category: "Algebra & Variables" },
    { label: "a", value: "a", description: "Linear coefficient a", category: "Algebra & Variables" },
    { label: "b", value: "b", description: "Linear coefficient b", category: "Algebra & Variables" },
    { label: "c", value: "c", description: "Constant parameter c", category: "Algebra & Variables" },
    { label: "²", value: "^2", description: "Squared power exponent", category: "Algebra & Variables" },
    { label: "³", value: "^3", description: "Cubed power exponent", category: "Algebra & Variables" },
    { label: "^", value: "^", description: "Superscript power caret", category: "Algebra & Variables" },
    { label: "√", value: "sqrt(", description: "Square root generator function", category: "Algebra & Variables" },
    { label: "∛", value: "cbrt(", description: "Cube root generator functional", category: "Algebra & Variables" },
    { label: "π", value: "pi", description: "Pi ratio constant (3.14159)", category: "Algebra & Variables" },
    { label: "e", value: "e", description: "Euler's transcendental number (2.71828)", category: "Algebra & Variables" },
    { label: "i", value: "i", description: "Imaginary unit constant (sqrt(-1))", category: "Algebra & Variables" },
    
    // Trigonometric & Hyperbolic
    { label: "sin", value: "sin(", description: "Trigonometric sine function", category: "Trigonometry & Polar" },
    { label: "cos", value: "cos(", description: "Trigonometric cosine function", category: "Trigonometry & Polar" },
    { label: "tan", value: "tan(", description: "Trigonometric tangent function", category: "Trigonometry & Polar" },
    { label: "arcsin", value: "asin(", description: "Inverse sine trigonometric function", category: "Trigonometry & Polar" },
    { label: "arccos", value: "acos(", description: "Inverse cosine trigonometric function", category: "Trigonometry & Polar" },
    { label: "arctan", value: "atan(", description: "Inverse tangent trigonometric function", category: "Trigonometry & Polar" },
    { label: "θ", value: "θ", description: "Theta angular state", category: "Trigonometry & Polar" },
    { label: "α", value: "α", description: "Alpha coordinate angle", category: "Trigonometry & Polar" },
    { label: "β", value: "β", description: "Beta coordinate angle", category: "Trigonometry & Polar" },
    { label: "γ", value: "γ", description: "Gamma angular coordinate", category: "Trigonometry & Polar" },
    
    // Statistics & Set Theory
    { label: "μ", value: "μ", description: "Population mean (Arithmetic average)", category: "Stats & Sets" },
    { label: "σ", value: "σ", description: "Population Standard Deviation deviation", category: "Stats & Sets" },
    { label: "σ²", value: "σ^2", description: "Variance statistic value", category: "Stats & Sets" },
    { label: "x̄", value: "x̄", description: "Sample mean notation", category: "Stats & Sets" },
    { label: "r", value: "r", description: "Pearson correlation coefficient", category: "Stats & Sets" },
    { label: "P(A)", value: "P(A)", description: "Probability of event A occurring", category: "Stats & Sets" },
    { label: "nCr", value: "nCr", description: "Combinations (n choose r)", category: "Stats & Sets" },
    { label: "nPr", value: "nPr", description: "Permutations formula sequence", category: "Stats & Sets" },
    { label: "∈", value: " ∈ ", description: "Belongs to / Element of", category: "Stats & Sets" },
    { label: "∉", value: " ∉ ", description: "Does not belong to set", category: "Stats & Sets" },
    { label: "∀", value: "∀", description: "Universal quantifier (For all)", category: "Stats & Sets" },
    { label: "∃", value: "∃", description: "Existential quantifier (There exists)", category: "Stats & Sets" },
    { label: "∩", value: " ∩ ", description: "Set intersection operator", category: "Stats & Sets" },
    { label: "∪", value: " ∪ ", description: "Set union operator", category: "Stats & Sets" },
    
    // Equations & Relations
    { label: "±", value: "±", description: "Plus-minus sign operator", category: "Equations & Relations" },
    { label: "≠", value: " != ", description: "Inequality operator", category: "Equations & Relations" },
    { label: "≈", value: " ≈ ", description: "Approximately equal operator", category: "Equations & Relations" },
    { label: "≤", value: " <= ", description: "Less than or equal relation", category: "Equations & Relations" },
    { label: "≥", value: " >= ", description: "Greater than or equal relation", category: "Equations & Relations" },
    { label: "∝", value: " ∝ ", description: "Proportional relationship connector", category: "Equations & Relations" },
    { label: "log", value: "log(", description: "Logarithm base 10", category: "Equations & Relations" },
    { label: "ln", value: "ln(", description: "Natural log base e", category: "Equations & Relations" },
    { label: "!", value: "!", description: "Factorial operator", category: "Equations & Relations" }
  ],
  
  physics: [
    // Classical Dynamics & Mechanics
    { label: "F = m*a", value: "F = m*a", description: "Newton's Second Law of Motion", category: "Mechanics & Force" },
    { label: "p = m*v", value: "p = m*v", description: "Linear Momentum equation", category: "Mechanics & Force" },
    { label: "W = F*d", value: "W = F * d", description: "Mechanical Work done product", category: "Mechanics & Force" },
    { label: "KE = 0.5*m*v²", value: "0.5 * m * v^2", description: "Translational Kinetic Energy", category: "Mechanics & Force" },
    { label: "PE = m*g*h", value: "m * g * h", description: "Gravitational Potential Energy", category: "Mechanics & Force" },
    { label: "τ = I*α", value: "τ = I * α", description: "Rotational Torque equation", category: "Mechanics & Force" },
    { label: "F_g = G*m1*m2/r²", value: "F_g = (G * m1 * m2) / r^2", description: "Newton's universal law of gravity", category: "Mechanics & Force" },
    { label: "v = u + a*t", value: "v = u + a*t", description: "SUVAT 1st kinematic formula", category: "Mechanics & Force" },
    { label: "s = u*t + ½a*t²", value: "s = u*t + 0.5*a*t^2", description: "SUVAT displacement equation", category: "Mechanics & Force" },
    
    // Quantum & Relativistic
    { label: "E = mc²", value: "E = m * c^2", description: "Einstein's Mass-Energy Equivalence", category: "Quantum & Relativity" },
    { label: "E = h*f", value: "E = h * f", description: "Planck-Einstein Photon energy relation", category: "Quantum & Relativity" },
    { label: "λ = h/p", description: "De Broglie quantum matter wavelength", value: "λ = h/p", category: "Quantum & Relativity" },
    { label: "Δx*Δp ≥ ℏ/2", value: "Δx * Δp >= ħ/2", description: "Heisenberg uncertainty principle", category: "Quantum & Relativity" },
    { label: "Ĥψ = Eψ", value: "Ĥ * ψ = E * ψ", description: "Time-independent Schrödinger Equation", category: "Quantum & Relativity" },
    { label: "ħ", value: "ħ", description: "Dirac constant (Reduced Planck Planck's: h/2π)", category: "Quantum & Relativity" },
    { label: "ψ", value: "ψ", description: "Lower-case Psi wave function state", category: "Quantum & Relativity" },
    { label: "Ψ", value: "Ψ", description: "Capital Psi complete system wave function", category: "Quantum & Relativity" },
    
    // Thermodynamics
    { label: "PV = nRT", value: "P * V = n * R * T", description: "Universal Ideal Gas Law", category: "Thermodynamics" },
    { label: "ΔU = Q - W", value: "ΔU = Q - W", description: "First Law of thermodynamics", category: "Thermodynamics" },
    { label: "ΔS = dQ/T", value: "ΔS = dQ/T", description: "Entropy differential equation", category: "Thermodynamics" },
    { label: "k_B", value: "1.3806e-23", description: "Boltzmann physical constant (J/K)", category: "Thermodynamics" },
    { label: "R_gas", value: "8.314", description: "Universal gas constant (J/(mol*K))", category: "Thermodynamics" },
    
    // Electromagnetism & Circuits
    { label: "V = I*R", value: "V = I * R", description: "Ohm's electrical resistance law", category: "Electromagnetism" },
    { label: "P = V*I", value: "P = V * I", description: "Electrical Power formula", category: "Electromagnetism" },
    { label: "F = k*q₁q₂/r²", value: "F = (k * q1 * q2) / r^2", description: "Coulomb's Law of static charge attraction", category: "Electromagnetism" },
    { label: "B = μ₀I/2πr", value: "B = (μ0 * I) / (2 * pi * r)", description: "Ampere's simple line wire magnetic field", category: "Electromagnetism" },
    { label: "Φ_B", value: "Φ", description: "Magnetic Flux flux integral value", category: "Electromagnetism" },
    { label: "Ω", value: "Ω", description: "Ohm electrical resistance SI division", category: "Electromagnetism" },
    { label: "ε₀", value: "8.854e-12", description: "Permittivity of free space constant", category: "Electromagnetism" },
    { label: "μ₀", value: "1.257e-6", description: "Permeability of free space constant", category: "Electromagnetism" },
    
    // Waves & Optics
    { label: "c = f*λ", value: "c = f * λ", description: "Wave propagation speed formula", category: "Waves & Optics" },
    { label: "f = 1/T", value: "f = 1/T", description: "Inverse period frequency translation", category: "Waves & Optics" },
    { label: "λ", value: "λ", description: "Lambda (Wavelength wave distance)", category: "Waves & Optics" },
    { label: "ω", value: "ω", description: "Omega (Angular velocity radial frequency)", category: "Waves & Optics" },
    { label: "n₁sinθ₁=n₂sinθ₂", value: "n1 * sin(θ1) = n2 * sin(θ2)", description: "Snell's Law of optical light refraction", category: "Waves & Optics" },
    
    // Fundamental Constants
    { label: "c_light", value: "2.9979e8", description: "Speed of Light in Vacuum", category: "Physical Constants" },
    { label: "g_earth", value: "9.8066", description: "Earth surface standard gravity", category: "Physical Constants" },
    { label: "G_grav", value: "6.6743e-11", description: "Cavendish Newtonian gravity constant", category: "Physical Constants" },
    { label: "h_planck", value: "6.6261e-34", description: "Planck's Quantum boundary coefficient", category: "Physical Constants" },
    { label: "e_charge", value: "1.6022e-19", description: "Elementary electron electrical charge unit", category: "Physical Constants" }
  ],
  
  chemistry: [
    // Reactions & Dynamics
    { label: "→", value: " -> ", description: "Direct chemical reaction transition", category: "Reaction Dynamics" },
    { label: "⇌", value: " <=> ", description: "Reversible dynamic chemical equilibrium indicator", category: "Reaction Dynamics" },
    { label: "▲", value: " + heat -> ", description: "Applied endothermic heat of reaction", category: "Reaction Dynamics" },
    { label: "K_eq", value: "K_eq", description: "Reaction equilibrium constant equilibrium", category: "Reaction Dynamics" },
    { label: "K_a", value: "K_a", description: "Acid dissociation constant system", category: "Reaction Dynamics" },
    { label: "K_sp", value: "K_sp", description: "Solubility product constant metric", category: "Reaction Dynamics" },
    { label: "ΔG = ΔH - T*ΔS", value: "dG = dH - T * dS", description: "Gibbs Free Energy thermodynamic spontaneity equation", category: "Reaction Dynamics" },
    
    // Acid-Base Calculations
    { label: "pH = -log[H⁺]", value: "pH = -log(H)", description: "Acidity logarithmic scale", category: "Acid-Base Chemistry" },
    { label: "pOH = -log[OH⁻]", value: "pOH = -log(OH)", description: "Alkalinity logarithmic scale", category: "Acid-Base Chemistry" },
    { label: "pH + pOH = 14", value: "pH + pOH = 14", description: "Aqueous conjugate solvent equilibrium constant scale", category: "Acid-Base Chemistry" },
    
    // States & Stoichiometer
    { label: "(aq)", value: "(aq)", description: "Aqueous water solution stage state", category: "Stoichiometry & States" },
    { label: "(s)", value: "(s)", description: "Solid phase element condition", category: "Stoichiometry & States" },
    { label: "(l)", value: "(l)", description: "Liquid structural solvent state", category: "Stoichiometry & States" },
    { label: "(g)", value: "(g)", description: "Gaseous phase state", category: "Stoichiometry & States" },
    { label: "[A]", value: "[A]", description: "Molar concentration of species A", category: "Stoichiometry & States" },
    { label: "M (mol/L)", value: "mol / L", description: "Molarity unit formula weight", category: "Stoichiometry & States" },
    { label: "N_A", value: "6.0221e23", description: "Avogadro's Mole unit count constant", category: "Stoichiometry & States" },
    
    // Common Compounds / Formulas
    { label: "H₂O", value: "H2O", description: "Dihydrogen monoxide (Water)", category: "Chemical Compounds" },
    { label: "CO₂", value: "CO2", description: "Carbon Dioxide gas", category: "Chemical Compounds" },
    { label: "C₆H₁₂O₆", value: "C6H12O6", description: "Alpha-D-Glucose Sugar molecule", category: "Chemical Compounds" },
    { label: "NaCl", value: "NaCl", description: "Sodium Chloride (Common Table Salt)", category: "Chemical Compounds" },
    { label: "HCl", value: "HCl", description: "Hydrochloric Strong Acid", category: "Chemical Compounds" },
    { label: "HNO₃", value: "HNO3", description: "Nitric Strong Oxidizing Mineral Acid", category: "Chemical Compounds" },
    { label: "H₂SO₄", value: "H2SO4", description: "Sulfuric Dibasic Mineral Acid", category: "Chemical Compounds" },
    { label: "NaOH", value: "NaOH", description: "Sodium Hydroxide Strong Corrosive Alkali", category: "Chemical Compounds" },
    { label: "NH₃", value: "NH3", description: "Ammonia gas/solution weaker base", category: "Chemical Compounds" },
    { label: "CH₄", value: "CH4", description: "Methane simplest alkane hydrocarbon", category: "Chemical Compounds" },
    
    // Ions, Radicals, Subscripts
    { label: "⁺", value: "^+", description: "Positive monovalent cation charge", category: "Ions & Radicals" },
    { label: "⁻", value: "^-", description: "Negative monovalent anion charge", category: "Ions & Radicals" },
    { label: "²⁺", value: "^2+", description: "Divalent cationic charge indicator", category: "Ions & Radicals" },
    { label: "²⁻", value: "^2-", description: "Divalent anionic charge indicator", category: "Ions & Radicals" },
    { label: "e⁻", value: "e^-", description: "Free electron radical placeholder", category: "Ions & Radicals" },
    { label: "OH⁻", value: "OH^-", description: "Hydroxide polyatomic anion", category: "Ions & Radicals" },
    { label: "H₃O⁺", value: "H3O^+", description: "Hydronium polyatomic cation", category: "Ions & Radicals" },
    
    // Organic Chemistry
    { label: "-OH", value: "OH", description: "Hydroxyl functional group segment", category: "Organic Radicals" },
    { label: "-COOH", value: "COOH", description: "Carboxylic Acid organic subunit", category: "Organic Radicals" },
    { label: "-NH₂", value: "NH2", description: "Amine compound basic substituent", category: "Organic Radicals" },
    { label: "-CHO", value: "CHO", description: "Aldehyde carbon group connector", category: "Organic Radicals" },
    { label: "C₆H₆", value: "C6H6", description: "Benzene aromatic carbon rings", category: "Organic Radicals" }
  ],
  
  biology: [
    // Genetics Bases & Nucleic Acid
    { label: "DNA Gen", value: "DNA (5'-3')", description: "Deoxyribonucleic acid base coding sequence", category: "Genetics & Nucleic Acids" },
    { label: "RNA Gen", value: "RNA (5'-3')", description: "Ribonucleic acid base sequence translator", category: "Genetics & Nucleic Acids" },
    { label: "Adenine", value: "A", description: "Adenine Purine base (pairs with Thymine/Uracil)", category: "Genetics & Nucleic Acids" },
    { label: "Thymine", value: "T", description: "Thymine Pyrimidine base (DNA-specific)", category: "Genetics & Nucleic Acids" },
    { label: "Cytosine", value: "C", description: "Cytosine Pyrimidine base (pairs with Guanine)", category: "Genetics & Nucleic Acids" },
    { label: "Guanine", value: "G", description: "Guanine Purine base (pairs with Cytosine)", category: "Genetics & Nucleic Acids" },
    { label: "Uracil", value: "U", description: "Uracil base component (RNA-specific)", category: "Genetics & Nucleic Acids" },
    { label: "Codon", value: "AUG ", description: "Start codon (Methionine initialization sequence)", category: "Genetics & Nucleic Acids" },
    
    // Cell Biology & Kinetics
    { label: "ATP", value: "ATP", description: "Adenosine Triphosphate molecular currency", category: "Cell Bio & Kinetics" },
    { label: "NADPH", value: "NADPH", description: "Nicotinamide Adenine Dinucleotide Phosphate reducer", category: "Cell Bio & Kinetics" },
    { label: "K_m", value: "K_m", description: "Michaelis constant (substrate affinity constant)", category: "Cell Bio & Kinetics" },
    { label: "V_max", value: "V_max", description: "Maximal enzyme catalytic velocity saturation", category: "Cell Bio & Kinetics" },
    { label: "v = V_max*[S] / (K_m + [S])", value: "v = (V_max * S) / (K_m + S)", description: "Michaelis-Menten enzyme kinetics formulation", category: "Cell Bio & Kinetics" },
    { label: "Ψ_s", value: "Ψ_s", description: "Solute potential osmotic component of total water potential", category: "Cell Bio & Kinetics" },
    { label: "Ψ_p", value: "Ψ_p", description: "Pressure turgor potential element of water state", category: "Cell Bio & Kinetics" },
    { label: "Ψ = Ψ_s + Ψ_p", value: "Ψ = Ψ_s + Ψ_p", description: "Total cellular Water Potential equation", category: "Cell Bio & Kinetics" },
    
    // Genetics & Phenotypes
    { label: "♂ (male)", value: "♂", description: "Male lineage pedigree diagram constant", category: "Inheritance & Pedigrees" },
    { label: "♀ (female)", value: "♀", description: "Female lineage pedigree diagram indicator", category: "Inheritance & Pedigrees" },
    { label: "F₁ Gen", value: "F1 Offspring", description: "First filial generation cross progeny", category: "Inheritance & Pedigrees" },
    { label: "F₂ Gen", value: "F2 Offspring", description: "Second filial generation self-cross progeny", category: "Inheritance & Pedigrees" },
    { label: "X^R X^r", value: "X^R X^r", description: "Sex-linked carrier female genotype tracker", category: "Inheritance & Pedigrees" },
    { label: "X^R Y", value: "X^R Y", description: "Sex-linked hemizygous dominant male representation", category: "Inheritance & Pedigrees" },
    { label: "p² + 2pq + q² = 1", value: "p^2 + 2*p*q + q^2 = 1", description: "Hardy-Weinberg allele distribution equilibrium", category: "Inheritance & Pedigrees" },
    { label: "p + q = 1", value: "p + q = 1", description: "Sum of simple diallelic game frequencies", category: "Inheritance & Pedigrees" },
    
    // Ecology & Growth
    { label: "dN/dt = r*N", value: "dN/dt = r * N", description: "Exponential biological growth potential differential", category: "Ecology Dynamics" },
    { label: "dN/dt = r*N*(1-N/K)", value: "dN/dt = r * N * (1 - (N / K))", description: "Verhulst Logistic carrying capacity constrained growth", category: "Ecology Dynamics" },
    { label: "K (Cap)", value: "K", description: "Biological carrying capacity bounds parameter", category: "Ecology Dynamics" },
    { label: "Simpson Index", value: "D = sum(n * (n - 1)) / (N * (N - 1))", description: "Simpson's biodiversity richness concentration metric", category: "Ecology Dynamics" },
    { label: "Shannon Index", value: "H = -sum(p * ln(p))", description: "Shannon-Wiener entropy biological index", category: "Ecology Dynamics" }
  ],

  astrophysics: [
    // Kepler, Orbits & Cosmology
    { label: "T² = 4π²r³/GM", value: "T^2 = (4 * pi^2 * r^3) / (G * M)", description: "Kepler's Third law of planetary orbital periods", category: "Orbits & Cosmology" },
    { label: "v_orb = √(GM/r)", value: "v_orb = sqrt((G * M) / r)", description: "Circular orbital speed around a focal mass", category: "Orbits & Cosmology" },
    { label: "v_esc = √(2GM/r)", value: "v_esc = sqrt((2 * G * M) / r)", description: "Minimum parabolic escape velocity from a planet", category: "Orbits & Cosmology" },
    { label: "R_s = 2GM/c²", value: "R_s = (2 * G * M) / (c^2)", description: "Schwarzschild radius event horizon boundary", category: "Orbits & Cosmology" },
    { label: "v_rad = H₀*d", value: "v_rad = H0 * d", description: "Hubble's expansion law of cosmological recession", category: "Orbits & Cosmology" },
    { label: "L_* = 4πR²σT⁴", value: "L = 4 * pi * R^2 * 5.6703e-8 * T^4", description: "Stefan-Boltzmann stellar radiant energy luminosity", category: "Stellar Astrophysics" },
    { label: "λ_max = b/T", value: "λ_max = 2.8977e-3 / T", description: "Wien's thermal blackbody displacement law", category: "Stellar Astrophysics" },
    
    // Rocketry & Relativistic Space
    { label: "Δv = v_e * ln(m₀/m_f)", value: "dv = v_e * ln(m0 / mf)", description: "Tsiolkovsky rocket weight and drive equation", category: "Rocketry & Propulsion" },
    { label: "t' = t / √(1 - v²/c²)", value: "t_dilated = t / sqrt(1 - v^2 / c^2)", description: "Lorentz special relativistic time dilation", category: "Relativity & Spacetime" },
    { label: "t_g = t₀√(1 - 2GM/rc²)", value: "t_g = t0 * sqrt(1 - (2 * G * M) / (r * c^2))", description: "General relativistic gravitational time dilation", category: "Relativity & Spacetime" }
  ],

  finance: [
    // Corporate auditing & NPV
    { label: "NPV = ∑(CF_t/(1+r)ᵗ) - C₀", value: "NPV = sum(CF / (1 + r)^t) - C0", description: "Net Present Value of discounted future cashflows", category: "Corporate Finance & CA Audit" },
    { label: "WACC = (E/V)Re + (D/V)Rd(1-Tc)", value: "WACC = (E/V)*Re + (D/V)*Rd*(1-Tc)", description: "Weighted Average Cost of capital capitalization math", category: "Corporate Finance & CA Audit" },
    { label: "ROE = NPM * AT * FL", value: "ROE = NPM * AssetTurnover * Leverage", description: "DuPont breakdown (profit margin * asset turn * leverage)", category: "Corporate Finance & CA Audit" },
    { label: "FCFF = EBIT(1-t) + Dep - CapEx - ΔNWC", value: "FCFF = EBIT * (1 - t) + Dep - CapEx - dNWC", description: "Free Cash Flow to the Firm cash metrics", category: "Corporate Finance & CA Audit" },

    // Financial Markets & Options
    { label: "FV = PV * (1 + r)ⁿ", value: "FV = PV * (1 + r)^n", description: "Compound Interest future asset value projection", category: "Valuation & Derivatives" },
    { label: "CAGR = (EV/BV)^(1/n) - 1", value: "CAGR = (EV / BV)^(1 / n) - 1", description: "Compound Annual Growth Rate tracking metrics", category: "Valuation & Derivatives" },
    { label: "E(R_i) = R_f + β_i(E(R_m)-R_f)", value: "ER = Rf + Beta * (ERm - Rf)", description: "CAPM expected capitalization asset rate of return", category: "Portfolio & Derivative Risk" },
    { label: "Sharpe = (R_p - R_f) / σ_p", value: "Sharpe = (Rp - Rf) / sigma", description: "Sharpe risk ratio (excess reward over standard deviation)", category: "Portfolio & Derivative Risk" },
    { label: "d₁ = (ln(S/K) + (r + σ²/2)t)/σ√t", value: "d1 = (ln(S/K) + (r + sigma^2 / 2) * t) / (sigma * sqrt(t))", description: "Black-Scholes index log probability parameter d1", category: "Valuation & Derivatives" },
    { label: "Call = S*N(d₁) - K*e⁻ʳᵗ*N(d₂)", value: "Call = S * N_d1 - K * exp(-r * t) * N_d2", description: "Black-Scholes call option pricing evaluation pricing", category: "Valuation & Derivatives" }
  ]
};
