<?php

namespace App\Helpers;

class ToolRegistry
{
    /**
     * Auto-generated tool registry. All tools discovered from Blade templates.
     */
    protected static $tools = [
        'chemistry' => [
            'acid-base-titration-calculator' => ['title' => 'Acid-Base Titration Calculator', 'description' => 'Calculate concentration from titration data.'],
            'activation-energy-calculator' => ['title' => 'Activation Energy Calculator', 'description' => 'Calculate activation energy using the Arrhenius equation.'],
            'avogadro-number-calculator' => ['title' => 'avogadro-number-calculator', 'description' => 'Convert between moles and number of particles.'],
            'boiling-point-elevation-calculator' => ['title' => 'Boiling Point Elevation Calculator', 'description' => 'Calculate the boiling point elevation of a solution.'],
            'boyles-law-calculator' => ['title' => 'boyles-law-calculator', 'description' => ''],
            'buffer-ph-calculator' => ['title' => 'Buffer pH Calculator', 'description' => 'Calculate buffer pH using Henderson-Hasselbalch equation.'],
            'charles-law-calculator' => ['title' => 'charles-law-calculator', 'description' => ''],
            'dilution-calculator' => ['title' => 'Dilution Calculator', 'description' => 'Calculate dilution using C₁V₁ = C₂V₂.'],
            'electron-configuration-calculator' => ['title' => 'Electron Configuration Calculator', 'description' => 'Generate electron configuration for elements.'],
            'electronegativity-calculator' => ['title' => 'Electronegativity Difference Calculator', 'description' => 'Determine bond type from electronegativity difference.'],
            'empirical-formula-calculator' => ['title' => 'Empirical Formula Calculator', 'description' => 'Determine the empirical formula from percent composition.'],
            'enthalpy-calculator' => ['title' => 'Enthalpy of Reaction Calculator', 'description' => ''],
            'equilibrium-constant-calculator' => ['title' => 'Equilibrium Constant Calculator', 'description' => 'Calculate the equilibrium constant Kc or Kp.'],
            'freezing-point-depression-calculator' => ['title' => 'Freezing Point Depression Calculator', 'description' => 'Calculate the freezing point depression of a solution.'],
            'gibbs-free-energy-calculator' => ['title' => 'Gibbs Free Energy Calculator', 'description' => 'Calculate Gibbs free energy change.'],
            'half-life-calculator' => ['title' => 'Half-Life Calculator (Chemistry)', 'description' => 'Calculate radioactive or chemical half-life.'],
            'ideal-gas-law-calculator' => ['title' => 'Ideal Gas Law Calculator (PV = nRT)', 'description' => 'Free ideal gas law calculator. Solve for pressure, volume, temperature, or moles using PV = nRT. Step-by-step solutions with real-world examples.'],
            'lewis-structure-octet-calculator' => ['title' => 'Octet Rule Calculator', 'description' => 'Calculate electrons needed for the octet rule.'],
            'mass-to-moles-calculator' => ['title' => 'Mass to Moles Converter', 'description' => 'Convert between mass and moles.'],
            'molality-calculator' => ['title' => 'Molality Calculator', 'description' => 'Calculate the molality of a solution.'],
            'molar-mass-calculator' => ['title' => 'Molar Mass Calculator', 'description' => 'Calculate the molar mass of common compounds.'],
            'molarity-calculator' => ['title' => 'Molarity Calculator', 'description' => 'Calculate the molarity of a solution.'],
            'nernst-equation-calculator' => ['title' => 'Nernst Equation Calculator', 'description' => 'Calculate cell potential under non-standard conditions.'],
            'osmotic-pressure-calculator' => ['title' => 'Osmotic Pressure Calculator', 'description' => 'Calculate the osmotic pressure of a solution.'],
            'oxidation-number-calculator' => ['title' => 'Oxidation Number Calculator', 'description' => 'Calculate oxidation states in compounds.'],
            'percent-composition-calculator' => ['title' => 'Percent Composition Calculator', 'description' => 'Calculate the percent composition of elements in a compound.'],
            'ph-calculator' => ['title' => 'pH Calculator', 'description' => 'Calculate pH, pOH, [H⁺], and [OH⁻] from any one value.'],
            'radioactive-decay-calculator' => ['title' => 'Radioactive Decay Calculator', 'description' => 'Calculate remaining radioactive material.'],
            'rate-law-calculator' => ['title' => 'Rate Law Calculator', 'description' => 'Calculate reaction rate from rate law expression.'],
            'reaction-rate-calculator' => ['title' => 'Reaction Rate Calculator', 'description' => 'Calculate reaction rate from concentration changes.'],
            'solubility-product-calculator' => ['title' => 'Solubility Product (Ksp) Calculator', 'description' => 'Calculate solubility from Ksp.'],
            'solution-mixing-calculator' => ['title' => 'Solution Mixing Calculator', 'description' => 'Calculate the final concentration when mixing two solutions.'],
            'specific-heat-calculator' => ['title' => 'Specific Heat Calculator', 'description' => 'Calculate heat transfer using q = mcΔT.'],
            'stoichiometry-calculator' => ['title' => 'Stoichiometry Calculator', 'description' => 'Calculate amounts in chemical reactions using mole ratios.'],
            'theoretical-yield-calculator' => ['title' => 'Theoretical Yield Calculator', 'description' => 'Calculate theoretical and percent yield.'],
        ],
        'coordinate-geometry' => [
            'angle-between-lines-calculator' => ['title' => 'Angle Between Two Lines Calculator', 'description' => 'Calculate the angle between two lines given their slopes.'],
            'area-of-triangle-coordinates-calculator' => ['title' => 'Triangle Area (Coordinates) Calculator', 'description' => 'Calculate triangle area from vertex coordinates.'],
            'circle-equation-calculator' => ['title' => 'Circle Equation Calculator', 'description' => 'Find the equation of a circle from center and radius.'],
            'distance-formula-calculator' => ['title' => 'Distance Formula Calculator', 'description' => 'Calculate distance between two points in 2D or 3D.'],
            'ellipse-equation-calculator' => ['title' => 'Ellipse Equation Calculator', 'description' => 'Find properties of an ellipse from its equation.'],
            'hyperbola-calculator' => ['title' => 'Hyperbola Calculator', 'description' => 'Find properties of a hyperbola from its equation.'],
            'line-intersection-calculator' => ['title' => 'Line Intersection Calculator', 'description' => 'Find where two lines intersect.'],
            'midpoint-formula-calculator' => ['title' => 'Midpoint Formula Calculator', 'description' => 'Find the midpoint between two points.'],
            'parabola-calculator' => ['title' => 'Parabola Calculator', 'description' => 'Find the vertex, focus, and directrix of a parabola.'],
            'point-to-line-distance-calculator' => ['title' => 'Point to Line Distance Calculator', 'description' => 'Calculate the perpendicular distance from a point to a line.'],
            'section-formula-calculator' => ['title' => 'Section Formula Calculator', 'description' => 'Find a point that divides a segment in a given ratio.'],
            'slope-intercept-form-calculator' => ['title' => 'Slope-Intercept Form Calculator', 'description' => 'Find slope-intercept form y = mx + b from two points.'],
            'triangle-centroid-calculator' => ['title' => 'Triangle Centroid Calculator', 'description' => 'Find the centroid of a triangle.'],
        ],
        'engineering' => [
            'capacitor-calculator' => ['title' => 'Capacitor Calculator', 'description' => 'Calculate charge, voltage, or capacitance.'],
            'gear-ratio-calculator' => ['title' => 'Gear Ratio Calculator', 'description' => 'Calculate gear ratio and output speed/torque.'],
            'inductor-calculator' => ['title' => 'Inductor Energy Calculator', 'description' => 'Calculate energy stored in an inductor.'],
            'ohms-law-calculator' => ['title' => 'ohms-law-calculator', 'description' => 'Calculate voltage, current, or resistance.'],
            'power-electrical-calculator' => ['title' => 'Electrical Power Calculator', 'description' => 'Calculate electrical power from voltage and current.'],
            'rc-time-constant-calculator' => ['title' => 'RC Time Constant Calculator', 'description' => 'Calculate the RC time constant and charging curves.'],
            'resistor-color-code-calculator' => ['title' => 'Resistor Color Code Calculator', 'description' => 'Calculate resistance from color bands.'],
            'transformer-calculator' => ['title' => 'Transformer Calculator', 'description' => 'Calculate transformer turns ratio and output.'],
            'wire-gauge-calculator' => ['title' => 'Wire Gauge Calculator', 'description' => 'Calculate wire resistance and current capacity by AWG.'],
        ],
        'everyday' => [
            'age-calculator' => ['title' => 'Age Calculator', 'description' => 'Calculate exact age in years, months, and days.'],
            'date-difference-calculator' => ['title' => 'Date Difference Calculator', 'description' => 'Calculate the difference between two dates.'],
            'discount-calculator' => ['title' => 'Discount Calculator', 'description' => 'Calculate the final price after discount.'],
            'electricity-cost-calculator' => ['title' => 'Electricity Cost Calculator', 'description' => 'Calculate electricity cost of an appliance.'],
            'gpa-calculator' => ['title' => 'GPA Calculator', 'description' => 'Calculate Grade Point Average from letter grades.'],
            'love-calculator' => ['title' => 'Love Calculator', 'description' => 'Calculate love compatibility (just for fun!).'],
            'paint-calculator' => ['title' => 'Paint Calculator', 'description' => 'Calculate paint needed for a room.'],
            'random-number-generator' => ['title' => 'Random Number Generator', 'description' => 'Generate random numbers within a range.'],
        ],
        'finance' => [
            'compound-interest-calculator' => ['title' => 'Compound Interest Calculator - Free Online', 'description' => 'Free compound interest calculator. Calculate how your savings or investments grow over time with monthly, quarterly, or yearly compounding. Includes formula breakdown and growth chart.'],
            'currency-exchange-calculator' => ['title' => 'Currency Exchange Calculator', 'description' => 'Calculate currency conversion at a given rate.'],
            'depreciation-calculator' => ['title' => 'Depreciation Calculator', 'description' => 'Calculate asset depreciation using straight-line method.'],
            'loan-calculator' => ['title' => 'Loan Payment Calculator', 'description' => 'Calculate monthly loan payments.'],
            'mortgage-calculator' => ['title' => 'Mortgage Calculator', 'description' => 'Calculate mortgage payments with taxes and insurance.'],
            'roi-calculator' => ['title' => 'ROI Calculator', 'description' => 'Calculate Return on Investment.'],
            'savings-calculator' => ['title' => 'Savings Goal Calculator', 'description' => 'Calculate how long to reach a savings goal with regular deposits.'],
            'tax-calculator' => ['title' => 'Income Tax Calculator (US)', 'description' => 'Estimate US federal income tax (2024 brackets).'],
            'tip-calculator' => ['title' => 'Tip Calculator', 'description' => 'Calculate tip amount and split the bill.'],
        ],
        'geometry' => [
            'circle-area-calculator' => ['title' => 'Circle Area Calculator', 'description' => 'Calculate the area and circumference of a circle.'],
            'cone-volume-calculator' => ['title' => 'Cone Volume Calculator', 'description' => 'Calculate the volume and surface area of a cone.'],
            'cylinder-volume-calculator' => ['title' => 'Cylinder Volume Calculator', 'description' => 'Calculate the volume and surface area of a cylinder.'],
            'ellipse-area-calculator' => ['title' => 'Ellipse Area Calculator', 'description' => 'Calculate the area and circumference of an ellipse.'],
            'hexagon-area-calculator' => ['title' => 'Regular Hexagon Calculator', 'description' => 'Calculate the area and perimeter of a regular hexagon.'],
            'parallelogram-area-calculator' => ['title' => 'Parallelogram Area Calculator', 'description' => 'Calculate the area of a parallelogram.'],
            'pentagon-area-calculator' => ['title' => 'Regular Pentagon Calculator', 'description' => 'Calculate the area and perimeter of a regular pentagon.'],
            'prism-volume-calculator' => ['title' => 'Prism Volume Calculator', 'description' => 'Calculate the volume of any prism.'],
            'pyramid-volume-calculator' => ['title' => 'Pyramid Volume Calculator', 'description' => 'Calculate the volume of a pyramid.'],
            'rectangle-area-calculator' => ['title' => 'Rectangle Area Calculator', 'description' => 'Calculate the area and perimeter of a rectangle.'],
            'regular-polygon-area-calculator' => ['title' => 'Regular Polygon Area Calculator', 'description' => 'Calculate the area of a regular polygon.'],
            'rhombus-area-calculator' => ['title' => 'Rhombus Area Calculator', 'description' => 'Calculate the area of a rhombus from its diagonals.'],
            'sector-area-calculator' => ['title' => 'Sector Area Calculator', 'description' => 'Calculate the area and arc length of a circular sector.'],
            'segment-area-calculator' => ['title' => 'Circle Segment Area Calculator', 'description' => 'Calculate the area of a circular segment.'],
            'sphere-volume-calculator' => ['title' => 'Sphere Volume Calculator', 'description' => 'Calculate the volume and surface area of a sphere.'],
            'square-area-calculator' => ['title' => 'Square Area Calculator', 'description' => 'Calculate the area, perimeter, and diagonal of a square.'],
            'torus-volume-calculator' => ['title' => 'Torus Volume Calculator', 'description' => 'Calculate the volume and surface area of a torus (donut shape).'],
            'trapezoid-area-calculator' => ['title' => 'Trapezoid Area Calculator', 'description' => 'Calculate the area of a trapezoid.'],
            'triangle-area-calculator' => ['title' => 'Triangle Area Calculator', 'description' => 'Calculate the area of a triangle using base and height.'],
        ],
        'health' => [
            'blood-alcohol-calculator' => ['title' => 'Blood Alcohol Calculator', 'description' => 'Estimate BAC using the Widmark formula.'],
            'bmi-calculator' => ['title' => 'BMI Calculator - Body Mass Index', 'description' => 'Free BMI Calculator. Calculate your Body Mass Index using height and weight. Understand BMI categories, health risks, and what your BMI means with detailed explanations.'],
            'bmr-calculator' => ['title' => 'BMR Calculator', 'description' => 'Calculate Basal Metabolic Rate.'],
            'body-fat-percentage-calculator' => ['title' => 'Body Fat Percentage Calculator', 'description' => 'Estimate body fat percentage using the Navy method.'],
            'calorie-calculator' => ['title' => 'Daily Calorie Calculator', 'description' => 'Calculate daily calorie needs based on BMR and activity.'],
            'heart-rate-zone-calculator' => ['title' => 'Heart Rate Zone Calculator', 'description' => 'Calculate target heart rate zones for exercise.'],
            'ideal-weight-calculator' => ['title' => 'Ideal Weight Calculator', 'description' => 'Calculate ideal body weight using various formulas.'],
            'macro-calculator' => ['title' => 'Macronutrient Calculator', 'description' => 'Calculate daily macronutrient targets.'],
            'pregnancy-due-date-calculator' => ['title' => 'Pregnancy Due Date Calculator', 'description' => 'Calculate estimated due date from last menstrual period.'],
            'sleep-cycle-calculator' => ['title' => 'Sleep Cycle Calculator', 'description' => 'Calculate optimal wake-up times based on sleep cycles.'],
            'waist-to-hip-ratio-calculator' => ['title' => 'Waist-to-Hip Ratio Calculator', 'description' => 'Calculate waist-to-hip ratio for health risk assessment.'],
            'water-intake-calculator' => ['title' => 'Water Intake Calculator', 'description' => 'Calculate recommended daily water intake.'],
        ],
        'math' => [
            'absolute-value-calculator' => ['title' => 'Absolute Value Calculator', 'description' => 'Calculate the absolute value of any number.'],
            'absolute-value-equation-calculator' => ['title' => 'Absolute Value Equation Solver', 'description' => 'Solve equations of the form |ax + b| = c.'],
            'adding-fractions-calculator' => ['title' => 'Adding Fractions Calculator', 'description' => 'Add two fractions with step-by-step simplification.'],
            'ai-math-solver' => ['title' => 'AI Math Solver - Step by Step Solutions with Graphs', 'description' => 'Solve any math problem instantly with our free AI Math Solver. Get step-by-step solutions, interactive graphs, and AI tutoring for algebra, calculus, trigonometry, and more.'],
            'anova-calculator' => ['title' => 'One-Way ANOVA Calculator', 'description' => 'Perform one-way ANOVA on multiple groups.'],
            'antilog-calculator' => ['title' => 'Antilog Calculator', 'description' => 'Calculate the antilogarithm (inverse of logarithm).'],
            'arccos-calculator' => ['title' => 'Arccosine Calculator', 'description' => 'Calculate the inverse cosine (arccos) of a value.'],
            'arcsin-calculator' => ['title' => 'Arcsine Calculator', 'description' => 'Calculate the inverse sine (arcsin) of a value.'],
            'arctan-calculator' => ['title' => 'Arctangent Calculator', 'description' => 'Calculate the inverse tangent (arctan) of a value.'],
            'arithmetic-mean-calculator' => ['title' => 'Arithmetic Mean Calculator', 'description' => 'Calculate the arithmetic mean of multiple numbers.'],
            'arithmetic-sequence-calculator' => ['title' => 'Arithmetic Sequence Calculator', 'description' => 'Find nth term and sum of arithmetic sequence.'],
            'bayes-theorem-calculator' => ['title' => 'bayes-theorem-calculator', 'description' => ''],
            'beta-function-calculator' => ['title' => 'Beta Function Calculator', 'description' => 'Calculate the beta function B(a,b).'],
            'binary-to-decimal-calculator' => ['title' => 'Binary to Decimal Calculator', 'description' => 'Convert binary numbers to decimal.'],
            'binomial-coefficient-calculator' => ['title' => 'Binomial Coefficient Calculator', 'description' => 'Calculate binomial coefficients (n choose k).'],
            'binomial-theorem-calculator' => ['title' => 'Binomial Theorem Calculator', 'description' => 'Expand (a+b)^n using the binomial theorem.'],
            'boolean-algebra-calculator' => ['title' => 'Boolean Algebra Calculator', 'description' => 'Evaluate Boolean expressions (AND, OR, NOT).'],
            'cartesian-product-calculator' => ['title' => 'Cartesian Product Calculator', 'description' => 'Find the Cartesian product of two sets.'],
            'chi-square-calculator' => ['title' => 'Chi-Square Test Calculator', 'description' => 'Calculate the chi-square statistic for goodness of fit.'],
            'combination-calculator' => ['title' => 'Combination Calculator', 'description' => 'Calculate combinations C(n,r) — unordered selections.'],
            'completing-the-square-calculator' => ['title' => 'Completing the Square Calculator', 'description' => 'Convert ax² + bx + c to a(x-h)² + k form.'],
            'complex-number-calculator' => ['title' => 'Complex Number Calculator', 'description' => 'Perform operations on complex numbers.'],
            'compound-interest-formula-calculator' => ['title' => 'Compound Interest Calculator', 'description' => 'Calculate compound interest with different compounding frequencies.'],
            'confidence-interval-calculator' => ['title' => 'Confidence Interval Calculator', 'description' => 'Calculate confidence intervals for the population mean.'],
            'continued-fraction-calculator' => ['title' => 'Continued Fraction Calculator', 'description' => 'Express a number as a continued fraction.'],
            'correlation-calculator' => ['title' => 'Correlation Calculator', 'description' => 'Calculate Pearson correlation coefficient between two datasets.'],
            'cos-calculator' => ['title' => 'Cosine Calculator', 'description' => 'Calculate the cosine of an angle in degrees or radians.'],
            'cot-calculator' => ['title' => 'Cotangent Calculator', 'description' => 'Calculate the cotangent of an angle.'],
            'covariance-calculator' => ['title' => 'Covariance Calculator', 'description' => 'Calculate the covariance between two datasets.'],
            'cramer-rule-3x3-calculator' => ['title' => 'cramer-rule-3x3-calculator', 'description' => ''],
            'cross-product-calculator' => ['title' => 'Cross Product Calculator', 'description' => 'Calculate the cross product of two 3D vectors.'],
            'csc-calculator' => ['title' => 'Cosecant Calculator', 'description' => 'Calculate the cosecant of an angle.'],
            'cube-root-calculator' => ['title' => 'Cube Root Calculator', 'description' => 'Calculate the cube root of a number.'],
            'cubic-equation-calculator' => ['title' => 'Cubic Equation Calculator', 'description' => 'Find one real root of a cubic equation ax³ + bx² + cx + d = 0.'],
            'decimal-to-binary-calculator' => ['title' => 'Decimal to Binary Calculator', 'description' => 'Convert decimal numbers to binary.'],
            'decimal-to-fraction-calculator' => ['title' => 'Decimal to Fraction Calculator', 'description' => 'Convert a decimal number to a fraction.'],
            'degrees-to-radians-calculator' => ['title' => 'Degrees to Radians Calculator', 'description' => 'Convert angles from degrees to radians.'],
            'derivative-calculator' => ['title' => 'Numerical Derivative Calculator', 'description' => 'Approximate the derivative of a function at a point.'],
            'discriminant-calculator' => ['title' => 'Discriminant Calculator', 'description' => 'Calculate the discriminant of a quadratic equation.'],
            'distance-between-points-calculator' => ['title' => 'Distance Between Points Calculator', 'description' => 'Calculate the distance between two points.'],
            'dividing-fractions-calculator' => ['title' => 'Dividing Fractions Calculator', 'description' => 'Divide two fractions (multiply by reciprocal).'],
            'divisibility-checker' => ['title' => 'Divisibility Rules Checker', 'description' => 'Check divisibility by common numbers.'],
            'dot-product-calculator' => ['title' => 'Dot Product Calculator', 'description' => 'Calculate the dot product of two vectors.'],
            'double-angle-formula-calculator' => ['title' => 'Double Angle Formula Calculator', 'description' => 'Calculate sin(2θ), cos(2θ), and tan(2θ) from angle θ.'],
            'eigenvalue-calculator' => ['title' => 'Eigenvalue Calculator (2×2)', 'description' => 'Calculate eigenvalues of a 2×2 matrix.'],
            'error-function-calculator' => ['title' => 'Error Function (erf) Calculator', 'description' => 'Calculate the error function value.'],
            'exponent-calculator' => ['title' => 'Exponent Calculator', 'description' => 'Calculate the power of a number (base raised to exponent).'],
            'exponential-decay-calculator' => ['title' => 'Exponential Decay Calculator', 'description' => 'Calculate exponential decay (half-life).'],
            'exponential-growth-calculator' => ['title' => 'Exponential Growth Calculator', 'description' => 'Calculate exponential growth or decay.'],
            'f-test-calculator' => ['title' => 'F-Test Calculator', 'description' => 'Calculate the F-statistic for comparing two variances.'],
            'factorial-calculator' => ['title' => 'Factorial Calculator', 'description' => 'Calculate n! (n factorial) for a non-negative integer.'],
            'fibonacci-calculator' => ['title' => 'Fibonacci Calculator', 'description' => 'Calculate the nth Fibonacci number.'],
            'fourier-series-calculator' => ['title' => 'Fourier Series Calculator', 'description' => 'Compute Fourier coefficients for common waveforms.'],
            'fraction-calculator' => ['title' => 'Fraction Calculator - Add, Subtract, Multiply, Divide Fractions', 'description' => 'Free online fraction calculator. Add, subtract, multiply, and divide fractions with step-by-step solutions. Simplify fractions and convert to decimals.'],
            'fraction-to-decimal-calculator' => ['title' => 'Fraction to Decimal Calculator', 'description' => 'Convert a fraction to its decimal representation.'],
            'future-value-calculator' => ['title' => 'Future Value Calculator', 'description' => 'Calculate the future value of a present amount.'],
            'gamma-function-calculator' => ['title' => 'Gamma Function Calculator', 'description' => 'Calculate the gamma function Γ(n).'],
            'gcd-calculator' => ['title' => 'GCD Calculator', 'description' => 'Calculate the Greatest Common Divisor of two numbers.'],
            'geometric-mean-calculator' => ['title' => 'Geometric Mean Calculator', 'description' => 'Calculate the geometric mean of a set of positive numbers.'],
            'geometric-sequence-calculator' => ['title' => 'Geometric Sequence Calculator', 'description' => 'Find nth term and sum of geometric sequence.'],
            'golden-ratio-calculator' => ['title' => 'Golden Ratio Calculator', 'description' => 'Calculate golden ratio related values.'],
            'greatest-integer-function-calculator' => ['title' => 'Floor/Ceiling Function Calculator', 'description' => 'Calculate floor and ceiling of a number.'],
            'half-angle-formula-calculator' => ['title' => 'Half Angle Formula Calculator', 'description' => 'Calculate sin(θ/2), cos(θ/2), and tan(θ/2) from angle θ.'],
            'harmonic-mean-calculator' => ['title' => 'Harmonic Mean Calculator', 'description' => 'Calculate the harmonic mean of a set of positive numbers.'],
            'heron-formula-calculator' => ['title' => 'heron-formula-calculator', 'description' => ''],
            'hexadecimal-calculator' => ['title' => 'Hexadecimal Calculator', 'description' => 'Convert between hexadecimal and decimal.'],
            'inequality-solver' => ['title' => 'Inequality Solver', 'description' => 'Solve linear inequalities ax + b < c.'],
            'integral-calculator' => ['title' => 'Numerical Integral Calculator', 'description' => ''],
            'interpolation-calculator' => ['title' => 'Linear Interpolation Calculator', 'description' => 'Interpolate between two known data points.'],
            'interquartile-range-calculator' => ['title' => 'Interquartile Range (IQR) Calculator', 'description' => 'Calculate Q1, Q3, and IQR of a dataset.'],
            'inverse-function-calculator' => ['title' => 'Inverse Function Calculator', 'description' => 'Find the inverse of simple functions.'],
            'lagrange-interpolation-calculator' => ['title' => 'Lagrange Interpolation Calculator', 'description' => 'Interpolate using Lagrange polynomial.'],
            'law-of-cosines-calculator' => ['title' => 'Law of Cosines Calculator', 'description' => 'Find the third side of a triangle using the Law of Cosines.'],
            'law-of-sines-calculator' => ['title' => 'Law of Sines Calculator', 'description' => 'Solve triangles using the Law of Sines.'],
            'lcm-calculator' => ['title' => 'LCM Calculator', 'description' => 'Calculate the Least Common Multiple of two numbers.'],
            'limits-calculator' => ['title' => 'Limit Calculator', 'description' => 'Evaluate limits of functions numerically.'],
            'linear-equation-calculator' => ['title' => 'Linear Equation Calculator', 'description' => 'Solve linear equations of the form ax + b = c.'],
            'linear-regression-calculator' => ['title' => 'Linear Regression Calculator', 'description' => 'Find the line of best fit y = mx + b.'],
            'logarithm-calculator' => ['title' => 'Logarithm Calculator', 'description' => 'Calculate logarithms with any base.'],
            'long-division-calculator' => ['title' => 'Long Division Calculator', 'description' => 'Perform long division with step-by-step process.'],
            'matrix-addition-calculator' => ['title' => 'Matrix Addition Calculator (2×2)', 'description' => 'Add or subtract two 2×2 matrices.'],
            'matrix-determinant-calculator' => ['title' => 'Matrix Determinant Calculator', 'description' => 'Calculate the determinant of a 2×2 matrix.'],
            'matrix-inverse-calculator' => ['title' => 'Matrix Inverse Calculator (2×2)', 'description' => 'Calculate the inverse of a 2×2 matrix.'],
            'matrix-multiplication-calculator' => ['title' => 'Matrix Multiplication Calculator (2×2)', 'description' => 'Multiply two 2×2 matrices.'],
            'matrix-rank-calculator' => ['title' => 'Matrix Rank Calculator (2×2)', 'description' => 'Calculate the rank of a 2×2 matrix.'],
            'matrix-transpose-calculator' => ['title' => 'Matrix Transpose Calculator', 'description' => 'Transpose a 2×2 or 3×3 matrix.'],
            'mean-calculator' => ['title' => 'Mean Calculator', 'description' => 'Calculate the arithmetic mean (average) of a set of numbers.'],
            'median-calculator' => ['title' => 'Median Calculator', 'description' => 'Find the median (middle value) of a dataset.'],
            'midpoint-calculator' => ['title' => 'Midpoint Calculator', 'description' => 'Find the midpoint between two points.'],
            'mixed-fraction-calculator' => ['title' => 'Mixed Fraction Calculator', 'description' => 'Convert between mixed numbers and improper fractions.'],
            'mod-calculator' => ['title' => 'Modulo Calculator', 'description' => 'Calculate the remainder of integer division.'],
            'mode-calculator' => ['title' => 'Mode Calculator', 'description' => 'Find the mode (most frequent value) of a dataset.'],
            'multiplying-fractions-calculator' => ['title' => 'Multiplying Fractions Calculator', 'description' => 'Multiply two fractions with step-by-step simplification.'],
            'natural-log-calculator' => ['title' => 'Natural Log Calculator', 'description' => 'Calculate the natural logarithm (base e) of a number.'],
            'newtons-method-calculator' => ['title' => 'newtons-method-calculator', 'description' => ''],
            'normal-distribution-calculator' => ['title' => 'Normal Distribution Calculator', 'description' => 'Calculate probabilities for the normal distribution using z-scores.'],
            'number-base-converter' => ['title' => 'Number Base Converter', 'description' => 'Convert between any two number bases (2-36).'],
            'number-sequence-calculator' => ['title' => 'Number Sequence Calculator', 'description' => 'Identify and extend number sequences.'],
            'octal-calculator' => ['title' => 'Octal Calculator', 'description' => 'Convert between octal and decimal.'],
            'partial-fraction-calculator' => ['title' => 'Partial Fraction Decomposition', 'description' => 'Decompose a rational function into partial fractions.'],
            'pascals-triangle-calculator' => ['title' => 'pascals-triangle-calculator', 'description' => ''],
            'percentage-calculator' => ['title' => 'Percentage Calculator - Calculate Percentages Online', 'description' => 'Free online percentage calculator. Find what percent of a number is, calculate percentage increase or decrease, and convert fractions to percentages with step-by-step explanations.'],
            'percentage-decrease-calculator' => ['title' => 'Percentage Decrease Calculator', 'description' => 'Calculate the percentage decrease between two values.'],
            'percentage-error-calculator' => ['title' => 'Percentage Error Calculator', 'description' => 'Calculate percentage error between experimental and actual values.'],
            'percentage-increase-calculator' => ['title' => 'Percentage Increase Calculator', 'description' => 'Calculate the percentage increase between two values.'],
            'percentage-off-calculator' => ['title' => 'Percentage Off Calculator', 'description' => 'Calculate the discounted price after a percentage off.'],
            'percentile-calculator' => ['title' => 'Percentile Calculator', 'description' => 'Calculate percentile rank of a value in a dataset.'],
            'perfect-square-calculator' => ['title' => 'Perfect Square Calculator', 'description' => 'Check if a number is a perfect square and find the root.'],
            'permutation-calculator' => ['title' => 'Permutation Calculator', 'description' => 'Calculate permutations P(n,r) — ordered arrangements.'],
            'polar-to-rectangular-calculator' => ['title' => 'Polar to Rectangular Converter', 'description' => 'Convert polar coordinates (r,θ) to rectangular (x,y).'],
            'polynomial-roots-calculator' => ['title' => 'Polynomial Roots Calculator', 'description' => 'Find roots of polynomials up to degree 4.'],
            'power-set-calculator' => ['title' => 'Power Set Calculator', 'description' => 'Generate the power set (all subsets) of a set.'],
            'present-value-calculator' => ['title' => 'Present Value Calculator', 'description' => 'Calculate the present value of a future amount.'],
            'prime-factorization-calculator' => ['title' => 'Prime Factorization Calculator', 'description' => 'Find the prime factors of a number.'],
            'prime-number-checker' => ['title' => 'Prime Number Checker', 'description' => 'Check if a number is prime and find factors.'],
            'probability-calculator' => ['title' => 'Probability Calculator', 'description' => 'Calculate probability from favorable and total outcomes.'],
            'product-notation-calculator' => ['title' => 'Product Calculator (Π)', 'description' => 'Calculate the product of a series Π f(i) from i=a to b.'],
            'proportion-calculator' => ['title' => 'Proportion Calculator', 'description' => 'Solve proportions: if a/b = c/x, find x.'],
            'pythagorean-theorem-calculator' => ['title' => 'Pythagorean Theorem Calculator', 'description' => 'Find any side of a right triangle.'],
            'quadratic-equation-calculator' => ['title' => 'Quadratic Equation Calculator & Solver', 'description' => 'Free online quadratic equation calculator. Solve ax² + bx + c = 0 with step-by-step solutions, discriminant analysis, and interactive parabola graph. Learn the quadratic formula with examples.'],
            'quadratic-formula-calculator' => ['title' => 'Quadratic Formula Calculator', 'description' => 'Solve quadratic equations ax² + bx + c = 0 using the quadratic formula.'],
            'radians-to-degrees-calculator' => ['title' => 'Radians to Degrees Calculator', 'description' => 'Convert angles from radians to degrees.'],
            'ratio-calculator' => ['title' => 'Ratio Calculator', 'description' => 'Simplify ratios and find equivalent ratios.'],
            'rectangular-to-polar-calculator' => ['title' => 'Rectangular to Polar Converter', 'description' => 'Convert rectangular coordinates (x,y) to polar (r,θ).'],
            'regression-slope-calculator' => ['title' => 'Regression Slope Calculator', 'description' => 'Calculate the slope and intercept of the regression line.'],
            'right-triangle-calculator' => ['title' => 'Right Triangle Calculator', 'description' => 'Calculate sides and angles of a right triangle.'],
            'roman-numeral-converter' => ['title' => 'Roman Numeral Converter', 'description' => 'Convert between Arabic and Roman numerals.'],
            'root-mean-square-calculator' => ['title' => 'Root Mean Square (RMS) Calculator', 'description' => 'Calculate the RMS of a set of values.'],
            'rounding-calculator' => ['title' => 'Rounding Calculator', 'description' => 'Round a number to specified decimal places.'],
            'scientific-notation-calculator' => ['title' => 'Scientific Notation Calculator', 'description' => 'Convert numbers to and from scientific notation.'],
            'scientific-notation-converter' => ['title' => 'Scientific Notation Converter', 'description' => 'Convert between standard and scientific notation.'],
            'sec-calculator' => ['title' => 'Secant Calculator', 'description' => 'Calculate the secant of an angle.'],
            'set-operations-calculator' => ['title' => 'Set Operations Calculator', 'description' => 'Perform union, intersection, and difference on sets.'],
            'sigma-notation-calculator' => ['title' => 'Sigma Notation Calculator', 'description' => 'Evaluate sum using sigma notation.'],
            'significant-figures-calculator' => ['title' => 'Significant Figures Calculator', 'description' => 'Round a number to specified significant figures.'],
            'simple-interest-calculator' => ['title' => 'Simple Interest Calculator', 'description' => 'Calculate simple interest on a principal.'],
            'simplify-fractions-calculator' => ['title' => 'Simplify Fractions Calculator', 'description' => 'Reduce a fraction to its simplest form by dividing by the GCD.'],
            'sin-calculator' => ['title' => 'Sine Calculator', 'description' => 'Calculate the sine of an angle in degrees or radians.'],
            'slope-calculator' => ['title' => 'Slope Calculator', 'description' => 'Calculate the slope between two points.'],
            'spherical-coordinates-calculator' => ['title' => 'Spherical Coordinates Calculator', 'description' => 'Convert between Cartesian and spherical coordinates.'],
            'square-root-calculator' => ['title' => 'Square Root Calculator - Find √x Online', 'description' => 'Free square root calculator. Find the square root of any number with step-by-step explanation. Includes perfect square checker and Nth root calculator.'],
            'standard-deviation-calculator' => ['title' => 'Standard Deviation Calculator', 'description' => 'Calculate standard deviation and variance of a dataset.'],
            'standard-error-calculator' => ['title' => 'Standard Error Calculator', 'description' => 'Calculate the standard error of the mean.'],
            'subtracting-fractions-calculator' => ['title' => 'Subtracting Fractions Calculator', 'description' => 'Subtract two fractions with step-by-step simplification.'],
            'sum-of-squares-calculator' => ['title' => 'Sum of Squares Calculator', 'description' => 'Calculate the sum of squares for a dataset.'],
            'summation-calculator' => ['title' => 'Summation Calculator', 'description' => 'Calculate the sum of a series Σ f(i) from i=a to b.'],
            'system-of-equations-calculator' => ['title' => 'System of Linear Equations Calculator', 'description' => ''],
            't-test-calculator' => ['title' => 'T-Test Calculator', 'description' => 'Perform a one-sample t-test.'],
            'tan-calculator' => ['title' => 'Tangent Calculator', 'description' => 'Calculate the tangent of an angle in degrees or radians.'],
            'taylor-series-calculator' => ['title' => 'Taylor Series Calculator', 'description' => 'Approximate a function using its Taylor series expansion.'],
            'trapezoidal-rule-calculator' => ['title' => 'Trapezoidal Rule Calculator', 'description' => 'Approximate a definite integral using the trapezoidal rule.'],
            'truth-table-generator' => ['title' => 'Truth Table Generator', 'description' => 'Generate truth tables for logical expressions.'],
            'variance-calculator' => ['title' => 'Variance Calculator', 'description' => 'Calculate the variance of a dataset.'],
            'vector-magnitude-calculator' => ['title' => 'Vector Magnitude Calculator', 'description' => 'Calculate the magnitude (length) of a vector.'],
            'vector-projection-calculator' => ['title' => 'Vector Projection Calculator', 'description' => 'Calculate the projection of vector a onto vector b.'],
            'weighted-average-calculator' => ['title' => 'Weighted Average Calculator', 'description' => 'Calculate the weighted average of a set of values.'],
            'z-score-calculator' => ['title' => 'Z-Score Calculator', 'description' => 'Calculate the z-score (standard score) of a data point.'],
        ],
        'physics' => [
            'ac-to-dc-converter-calculator' => ['title' => 'AC to DC Converter Calculator', 'description' => 'Convert AC voltage to DC voltage for different rectifier configurations.'],
            'acceleration-calculator' => ['title' => 'Acceleration Calculator', 'description' => 'Calculate acceleration from velocity change and time.'],
            'amount-of-substance-calculator' => ['title' => 'Amount of Substance Calculator', 'description' => 'Calculate number of moles from mass and molar mass.'],
            'angular-acceleration-calculator' => ['title' => 'Angular Acceleration Calculator', 'description' => 'Calculate angular acceleration from change in angular velocity.'],
            'antenna-gain-calculator' => ['title' => 'Antenna Gain Calculator', 'description' => 'Calculate antenna gain in dBi from directivity and efficiency.'],
            'average-velocity-calculator' => ['title' => 'Average Velocity Calculator', 'description' => 'Calculate average velocity from displacement and time.'],
            'batteries-charge-time-calculator' => ['title' => 'Battery Charge Time Calculator', 'description' => 'Calculate the time to charge a battery.'],
            'battery-life-calculator' => ['title' => 'Battery Life Calculator', 'description' => 'Calculate how long a battery will last from capacity and current draw.'],
            'bernoulli-equation-calculator' => ['title' => 'Bernoulli Equation Calculator', 'description' => ''],
            'bernoulli-numbers-calculator' => ['title' => 'Bernoulli Numbers Calculator', 'description' => 'Free Bernoulli Numbers Calculator. Compute Bernoulli numbers B(n) for fluid mechanics and mathematical series. Step-by-step solutions.'],
            'brake-horsepower-calculator' => ['title' => 'Brake Horsepower Calculator', 'description' => 'Calculate brake horsepower for pumps and engines.'],
            'broad-crested-weir-calculator' => ['title' => 'Broad Crested Weir Calculator', 'description' => 'Calculate flow rate over a broad-crested weir.'],
            'buoyancy-force-calculator' => ['title' => 'Buoyancy Force Calculator', 'description' => ''],
            'capacitance-calculator' => ['title' => 'Capacitance Calculator', 'description' => 'Calculate capacitance, charge, or voltage for a capacitor using Q = CV.'],
            'capacitive-reactance-calculator' => ['title' => 'Capacitive Reactance Calculator', 'description' => 'Calculate capacitive reactance in AC circuits.'],
            'carnot-efficiency-calculator' => ['title' => 'Carnot Efficiency Calculator', 'description' => 'Calculate the maximum theoretical efficiency of a heat engine.'],
            'centrifugal-force-calculator' => ['title' => 'Centrifugal Force Calculator', 'description' => 'Calculate centrifugal force in rotating reference frames.'],
            'centripetal-acceleration-calculator' => ['title' => 'Centripetal Acceleration Calculator', 'description' => 'Calculate centripetal acceleration for circular motion.'],
            'centripetal-force-calculator' => ['title' => 'Centripetal Force Calculator', 'description' => 'Calculate centripetal force for circular motion.'],
            'circular-velocity-calculator' => ['title' => 'Circular Velocity Calculator', 'description' => 'Calculate the velocity of an object in circular motion.'],
            'coulombs-law-calculator' => ['title' => 'coulombs-law-calculator', 'description' => 'Calculate the electrostatic force between two point charges.'],
            'critical-frequencies-calculator' => ['title' => 'Critical Frequency Calculator', 'description' => 'Calculate the critical frequency of a signal or resonant circuit.'],
            'cylindrical-tank-calculator' => ['title' => 'Cylindrical Tank Volume Calculator', 'description' => 'Calculate the volume of a cylindrical tank.'],
            'dc-voltage-drop-calculator' => ['title' => 'DC Voltage Drop Calculator', 'description' => 'Calculate voltage drop in DC electrical circuits based on cable length and current.'],
            'de-broglie-wavelength-calculator' => ['title' => 'De Broglie Wavelength Calculator', 'description' => 'Calculate the de Broglie wavelength of a particle.'],
            'density-calculator' => ['title' => 'Density Calculator', 'description' => 'Calculate density from mass and volume.'],
            'differential-pressure-calculator' => ['title' => 'Differential Pressure Calculator', 'description' => 'Calculate differential pressure from fluid column height.'],
            'displacement-calculator' => ['title' => 'Displacement Calculator', 'description' => 'Calculate displacement using initial velocity, acceleration, and time.'],
            'doppler-effect-calculator' => ['title' => 'Sound Wavelength Calculator', 'description' => 'Calculate sound wavelength from speed and frequency.'],
            'drag-force-calculator' => ['title' => 'Drag Force Calculator', 'description' => 'Calculate aerodynamic drag force on an object.'],
            'einstein-mass-energy-calculator' => ['title' => 'Einstein Mass-Energy Calculator', 'description' => 'Calculate energy equivalent of mass using E = mc².'],
            'elastic-potential-energy-calculator' => ['title' => 'Elastic Potential Energy Calculator', 'description' => 'Calculate the elastic potential energy stored in a spring.'],
            'electric-field-calculator' => ['title' => 'Electric Field Calculator', 'description' => 'Calculate the electric field due to a point charge.'],
            'electric-potential-calculator' => ['title' => 'Electric Potential Calculator', 'description' => 'Calculate the electric potential due to a point charge.'],
            'electrical-harmonics-calculator' => ['title' => 'Electrical Harmonics Calculator', 'description' => 'Calculate harmonic frequencies from the fundamental frequency.'],
            'electron-gain-calculator' => ['title' => 'Electron Gain/Loss Calculator', 'description' => 'Calculate the charge from electrons gained or lost.'],
            'energy-storage-calculator' => ['title' => 'Energy Storage Calculator', 'description' => 'Calculate energy stored in a capacitor or inductor.'],
            'entropy-calculator' => ['title' => 'Entropy Change Calculator', 'description' => 'Calculate entropy change for heat transfer at constant temperature.'],
            'escape-velocity-calculator' => ['title' => 'Escape Velocity Calculator', 'description' => 'Calculate the escape velocity from a celestial body.'],
            'euler-number-calculator' => ['title' => 'Euler Number Calculator', 'description' => 'Calculate the Euler number — dimensionless pressure drop in fluid flow.'],
            'find-weight-on-other-planets-calculator' => ['title' => 'Weight on Other Planets Calculator', 'description' => 'Calculate your weight on different planets in the solar system.'],
            'flow-rate-calculator' => ['title' => 'Flow Rate Calculator', 'description' => 'Free Flow Rate Calculator. Calculate Q = A × v with step-by-step solutions for fluid mechanics.'],
            'force-calculator' => ['title' => 'Force Calculator', 'description' => ''],
            'fourier-number-calculator' => ['title' => 'Fourier Number Calculator', 'description' => 'Calculate the Fourier number for transient heat conduction analysis.'],
            'frequency-calculator' => ['title' => 'Frequency Calculator', 'description' => 'Calculate frequency from wavelength and wave speed.'],
            'froude-number-calculator' => ['title' => 'Froude Number Calculator', 'description' => 'Free Froude Number Calculator. Compute Fr = v/√(gL) for open channel flow analysis.'],
            'gravitational-potential-energy-calculator' => ['title' => 'Gravitational Potential Energy (Orbital)', 'description' => 'Calculate gravitational PE between two masses at distance r.'],
            'heat-flow-calculator' => ['title' => 'Heat Flow Calculator', 'description' => 'Calculate heat flow using Q = mcΔT.'],
            'heat-transfer-rate-calculator' => ['title' => 'Heat Transfer Rate Calculator', 'description' => 'Calculate the rate of heat transfer through a material.'],
            'hooke-law-calculator' => ['title' => 'hooke-law-calculator', 'description' => ''],
            'horse-power-calculator' => ['title' => 'Horsepower Calculator', 'description' => 'Convert between horsepower and watts.'],
            'hydraulic-radius-calculator' => ['title' => 'Hydraulic Radius Calculator', 'description' => 'Free Hydraulic Radius Calculator. Compute R = A/P for channel flow with step-by-step solutions.'],
            'ideal-gas-law-physics-calculator' => ['title' => 'Ideal Gas Law Calculator (Physics)', 'description' => 'Calculate pressure, volume, temperature, or amount using PV = nRT.'],
            'impulse-with-time-calculator' => ['title' => 'Impulse Calculator (with Time)', 'description' => 'Calculate impulse from force and time duration.'],
            'impulse-with-velocity-calculator' => ['title' => 'Impulse Calculator (with Velocity)', 'description' => 'Calculate impulse from mass and velocity change.'],
            'inductive-reactance-calculator' => ['title' => 'Inductive Reactance Calculator', 'description' => 'Calculate inductive reactance in AC circuits.'],
            'kepler-third-law-calculator' => ['title' => 'kepler-third-law-calculator', 'description' => 'Calculate orbital period from semi-major axis or vice versa.'],
            'kilovolt-amps-calculator' => ['title' => 'Kilovolt-Amps Calculator', 'description' => 'Calculate apparent power in kVA.'],
            'kinematic-viscosity-calculator' => ['title' => 'Kinematic Viscosity Calculator', 'description' => 'Calculate kinematic viscosity from dynamic viscosity and density.'],
            'kinetic-energy-calculator' => ['title' => 'Kinetic Energy Calculator', 'description' => 'Calculate kinetic energy from mass and velocity.'],
            'kinetic-friction-calculator' => ['title' => 'Kinetic Friction Calculator', 'description' => 'Calculate kinetic (sliding) friction force.'],
            'knudsen-number-calculator' => ['title' => 'Knudsen Number Calculator', 'description' => 'Calculate the Knudsen number to determine flow regime (continuum vs molecular).'],
            'law-of-cooling-calculator' => ['title' => 'law-of-cooling-calculator', 'description' => ''],
            'leaf-springs-calculator' => ['title' => 'Leaf Spring Calculator', 'description' => 'Calculate leaf spring deflection under load.'],
            'lensmaker-equation-calculator' => ['title' => 'lensmaker-equation-calculator', 'description' => ''],
            'lewis-number-calculator' => ['title' => 'Lewis Number Calculator', 'description' => 'Calculate the Lewis number — ratio of thermal to mass diffusivity.'],
            'mach-number-calculator' => ['title' => 'Mach Number Calculator', 'description' => 'Free Mach Number Calculator. Determine subsonic, transonic, or supersonic flow with step-by-step solutions.'],
            'magnetic-field-solenoid-calculator' => ['title' => 'Solenoid Magnetic Field Calculator', 'description' => 'Calculate the magnetic field inside a solenoid.'],
            'magnetic-force-calculator' => ['title' => 'Magnetic Force Calculator', 'description' => 'Calculate the force on a moving charge in a magnetic field.'],
            'mass-flow-rate-calculator' => ['title' => 'Mass Flow Rate Calculator', 'description' => 'Calculate mass flow rate of a fluid.'],
            'mean-depth-calculator' => ['title' => 'Mean Depth Calculator', 'description' => 'Calculate mean hydraulic depth of a channel cross-section.'],
            'moment-calculator' => ['title' => 'Moment Calculator', 'description' => 'Calculate the moment (torque) of a force about a point.'],
            'moment-of-inertia-calculator' => ['title' => 'Moment of Inertia Calculator', 'description' => 'Calculate moment of inertia for common shapes.'],
            'momentum-with-time-calculator' => ['title' => 'Momentum Change Calculator', 'description' => 'Calculate momentum change from force and time.'],
            'momentum-with-velocity-calculator' => ['title' => 'Momentum Calculator (with Velocity)', 'description' => 'Calculate linear momentum from mass and velocity.'],
            'newton-force-calculator' => ['title' => 'newton-force-calculator', 'description' => ''],
            'newton-second-law-calculator' => ['title' => 'newton-second-law-calculator', 'description' => 'Calculate force, mass, or acceleration using F = ma.'],
            'newtons-law-of-gravity-calculator' => ['title' => 'newtons-law-of-gravity-calculator', 'description' => 'Calculate gravitational force between two masses.'],
            'nusselt-number-calculator' => ['title' => 'Nusselt Number Calculator', 'description' => 'Calculate the Nusselt number for convective heat transfer analysis.'],
            'ohms-law-current-calculator' => ['title' => 'ohms-law-current-calculator', 'description' => ''],
            'orbital-velocity-calculator' => ['title' => 'Orbital Velocity Calculator', 'description' => 'Calculate the orbital velocity for a circular orbit.'],
            'paper-calculator' => ['title' => 'Paper Weight Calculator', 'description' => 'Calculate paper weight and sheet count from dimensions and GSM.'],
            'parallel-plate-capacitor-calculator' => ['title' => 'Parallel Plate Capacitor Calculator', 'description' => 'Calculate capacitance of a parallel plate capacitor.'],
            'peclet-number-calculator' => ['title' => 'Peclet Number Calculator', 'description' => 'Calculate the Peclet number for heat or mass transfer in flowing fluids.'],
            'photoelectric-effect-calculator' => ['title' => 'Photoelectric Effect Calculator', 'description' => 'Calculate the kinetic energy of photoelectrons.'],
            'physical-pendulum-calculator' => ['title' => 'Physical Pendulum Calculator', 'description' => 'Calculate the period of a physical (compound) pendulum.'],
            'potential-energy-calculator' => ['title' => 'Potential Energy Calculator', 'description' => 'Calculate gravitational potential energy.'],
            'potentiometer-calculator' => ['title' => 'Potentiometer Calculator', 'description' => 'Calculate output voltage from a potentiometer (variable voltage divider).'],
            'power-with-velocity-calculator' => ['title' => 'Power Calculator (Force × Velocity)', 'description' => 'Calculate power from force and velocity.'],
            'power-with-work-calculator' => ['title' => 'Power Calculator (Work/Time)', 'description' => 'Calculate power from work done and time.'],
            'prandtl-number-calculator' => ['title' => 'Prandtl Number Calculator', 'description' => 'Calculate the Prandtl number — ratio of momentum diffusivity to thermal diffusivity.'],
            'projectile-motion-calculator' => ['title' => 'Projectile Motion Calculator', 'description' => 'Calculate range, max height, and time of flight for projectile motion.'],
            'pump-efficiency-calculator' => ['title' => 'Pump Efficiency Calculator', 'description' => 'Free Pump Efficiency Calculator. Compute η = Pout/Pin with step-by-step solutions.'],
            'radar-range-calculator' => ['title' => 'Radar Range Calculator', 'description' => 'Calculate maximum radar detection range.'],
            'rectangular-weir-calculator' => ['title' => 'Rectangular Weir Flow Rate Calculator', 'description' => 'Calculate flow rate over a rectangular weir using the Francis formula.'],
            'resultant-force-calculator' => ['title' => 'Resultant Force Calculator', 'description' => 'Calculate the resultant of two forces acting at an angle.'],
            'reynolds-number-calculator' => ['title' => 'Reynolds Number Calculator', 'description' => 'Free Reynolds Number Calculator. Determine flow regime (laminar/turbulent) with step-by-step solutions.'],
            'schmidt-number-calculator' => ['title' => 'Schmidt Number Calculator', 'description' => 'Calculate the Schmidt number — ratio of momentum to mass diffusivity.'],
            'schwarzschild-radius-calculator' => ['title' => 'Schwarzschild Radius Calculator', 'description' => 'Calculate the Schwarzschild radius (event horizon) of a black hole.'],
            'sherwood-number-calculator' => ['title' => 'Sherwood Number Calculator', 'description' => 'Calculate the Sherwood number for mass transfer analysis.'],
            'simple-pendulum-calculator' => ['title' => 'Simple Pendulum Calculator', 'description' => 'Calculate the period of a simple pendulum.'],
            'snells-law-calculator' => ['title' => 'snells-law-calculator', 'description' => ''],
            'sound-intensity-level-calculator' => ['title' => 'Sound Intensity Level Calculator', 'description' => 'Calculate sound intensity level in decibels.'],
            'sound-power-emitted-calculator' => ['title' => 'Sound Power Emitted Calculator', 'description' => 'Calculate sound power from intensity and area.'],
            'sound-pressure-level-calculator' => ['title' => 'Sound Pressure Level Calculator', 'description' => 'Calculate sound pressure level in dB from pressure.'],
            'specific-gas-constant-calculator' => ['title' => 'Specific Gas Constant Calculator', 'description' => 'Calculate the specific gas constant for any gas from the universal gas constant.'],
            'specific-volume-calculator' => ['title' => 'Specific Volume Calculator', 'description' => 'Free Specific Volume Calculator. Compute v = V/m or v = 1/ρ with step-by-step solutions.'],
            'speed-of-sound-calculator' => ['title' => 'Speed of Sound Calculator', 'description' => 'Calculate the speed of sound in air at a given temperature.'],
            'static-friction-calculator' => ['title' => 'Static Friction Calculator', 'description' => 'Calculate maximum static friction force.'],
            'stefan-boltzmann-calculator' => ['title' => 'Stefan-Boltzmann Law Calculator', 'description' => 'Calculate thermal radiation power using the Stefan-Boltzmann law.'],
            'stokes-law-calculator' => ['title' => 'stokes-law-calculator', 'description' => ''],
            'storage-capacity-rectangular-tank-calculator' => ['title' => 'Rectangular Tank Storage Calculator', 'description' => 'Calculate the storage capacity of a rectangular tank.'],
            'strain-calculator' => ['title' => 'Strain Calculator', 'description' => 'Calculate mechanical strain from change in length.'],
            'stress-calculator' => ['title' => 'Stress Calculator', 'description' => 'Calculate mechanical stress from force and area.'],
            'suvat-calculator' => ['title' => 'SUVAT Calculator', 'description' => 'Solve kinematics problems using SUVAT equations of motion.'],
            'terminal-velocity-calculator' => ['title' => 'Terminal Velocity Calculator', 'description' => 'Calculate terminal velocity of a falling object.'],
            'thermal-conductivity-calculator' => ['title' => 'Thermal Conductivity Calculator', 'description' => 'Calculate thermal conductivity from heat flow data.'],
            'thin-lens-equation-calculator' => ['title' => 'Thin Lens Equation Calculator', 'description' => 'Calculate image distance or focal length using the thin lens equation.'],
            'torque-calculator' => ['title' => 'Torque Calculator', 'description' => 'Calculate torque from force and moment arm distance.'],
            'torsional-pendulum-calculator' => ['title' => 'Torsional Pendulum Calculator', 'description' => 'Calculate the period of a torsional pendulum.'],
            'total-work-calculator' => ['title' => 'Total Work Calculator', 'description' => 'Calculate total work done from kinetic energy change (work-energy theorem).'],
            'transformer-calculator' => ['title' => 'Transformer Calculator', 'description' => 'Calculate transformer voltage, current, or turns ratio.'],
            'transverse-strength-calculator' => ['title' => 'Transverse Strength Calculator', 'description' => 'Calculate transverse rupture strength from a bending test.'],
            'velocity-calculator' => ['title' => 'Velocity Calculator', 'description' => 'Calculate velocity using initial velocity, acceleration, and time.'],
            'voltage-divider-calculator' => ['title' => 'Voltage Divider Calculator', 'description' => 'Calculate output voltage of a resistive voltage divider.'],
            'water-horsepower-calculator' => ['title' => 'Water Horsepower Calculator', 'description' => 'Calculate water horsepower — the theoretical minimum power to move water.'],
            'wavelength-calculator' => ['title' => 'Wavelength Calculator', 'description' => 'Calculate wavelength from frequency and wave speed.'],
            'weber-number-calculator' => ['title' => 'Weber Number Calculator', 'description' => 'Free Weber Number Calculator. Compute We = ρv²L/σ for droplet and surface tension analysis.'],
            'weight-force-calculator' => ['title' => 'Weight Force Calculator', 'description' => 'Calculate the weight (gravitational force) of an object.'],
            'wiens-displacement-law-calculator' => ['title' => 'wiens-displacement-law-calculator', 'description' => 'Calculate peak wavelength of thermal radiation.'],
            'work-calculator' => ['title' => 'Work Calculator', 'description' => 'Calculate work done by a force over a distance.'],
            'youngs-modulus-calculator' => ['title' => 'youngs-modulus-calculator', 'description' => ''],
        ],
        'sports' => [
            'batting-average-calculator' => ['title' => 'Batting Average Calculator', 'description' => 'Calculate batting average in baseball/cricket.'],
            'bowling-average-calculator' => ['title' => 'Bowling Average Calculator', 'description' => 'Calculate bowling average and strike rate in cricket.'],
            'calories-burned-calculator' => ['title' => 'Calories Burned Calculator', 'description' => 'Estimate calories burned during exercise.'],
            'one-rep-max-calculator' => ['title' => 'One Rep Max (1RM) Calculator', 'description' => 'Estimate your 1RM from submaximal lifts.'],
            'pace-calculator' => ['title' => 'Running Pace Calculator', 'description' => 'Calculate pace, speed, or time for running.'],
            'target-heart-rate-calculator' => ['title' => 'Target Heart Rate for Exercise', 'description' => 'Calculate target heart rate for different exercise intensities.'],
            'vo2-max-calculator' => ['title' => 'VO2 Max Calculator', 'description' => 'Estimate VO2 max from running performance.'],
        ],
        'unit-converter' => [
            'acceleration-converter' => ['title' => 'Acceleration Converter', 'description' => 'Convert between acceleration units.'],
            'angle-converter' => ['title' => 'Angle Converter', 'description' => 'Convert between degrees, radians, gradians, and turns.'],
            'area-converter' => ['title' => 'Area Converter', 'description' => 'Convert between square meters, acres, hectares, square feet, etc.'],
            'aspect-ratio-calculator' => ['title' => 'Aspect Ratio Calculator', 'description' => 'Calculate and convert display aspect ratios.'],
            'bmi-calculator' => ['title' => 'BMI Calculator', 'description' => 'Calculate Body Mass Index from height and weight.'],
            'clothing-size-converter' => ['title' => 'Clothing Size Converter', 'description' => 'Convert between US, UK, and EU clothing sizes.'],
            'color-converter' => ['title' => 'Color Converter', 'description' => 'Convert between HEX, RGB, and HSL color formats.'],
            'cooking-converter' => ['title' => 'Cooking Measurement Converter', 'description' => 'Convert between cups, tablespoons, teaspoons, mL, and oz.'],
            'data-storage-converter' => ['title' => 'Data Storage Converter', 'description' => 'Convert between bytes, KB, MB, GB, TB, and PB.'],
            'density-converter' => ['title' => 'Density Converter', 'description' => 'Convert between density units.'],
            'energy-converter' => ['title' => 'Energy Converter', 'description' => 'Convert between joules, calories, kWh, BTU, and eV.'],
            'flow-rate-converter' => ['title' => 'Flow Rate Converter', 'description' => 'Convert between flow rate units.'],
            'force-converter' => ['title' => 'Force Converter', 'description' => 'Convert between newtons, pounds-force, dynes, and kgf.'],
            'frequency-converter' => ['title' => 'Frequency Converter', 'description' => 'Convert between Hz, kHz, MHz, GHz, and rpm.'],
            'fuel-efficiency-converter' => ['title' => 'Fuel Efficiency Converter', 'description' => 'Convert between mpg, km/L, and L/100km.'],
            'illuminance-converter' => ['title' => 'Illuminance Converter', 'description' => 'Convert between lux, foot-candles, and phot.'],
            'length-converter' => ['title' => 'Length Converter - Convert Between Length Units', 'description' => 'Free online length converter. Convert between meters, feet, inches, centimeters, kilometers, miles, yards, and more length units instantly.'],
            'number-to-words-converter' => ['title' => 'Number to Words Converter', 'description' => 'Convert numbers to English words.'],
            'power-converter' => ['title' => 'Power Converter', 'description' => 'Convert between watts, horsepower, BTU/h, and kW.'],
            'pressure-converter' => ['title' => 'Pressure Converter', 'description' => 'Convert between Pa, atm, psi, bar, mmHg, and torr.'],
            'roman-to-arabic-converter' => ['title' => 'Roman to Arabic Converter', 'description' => 'Convert Roman numerals to Arabic numbers.'],
            'shoe-size-converter' => ['title' => 'Shoe Size Converter', 'description' => 'Convert between US, UK, and EU shoe sizes.'],
            'speed-converter' => ['title' => 'Speed Converter', 'description' => 'Convert between m/s, km/h, mph, knots, and ft/s.'],
            'temperature-converter' => ['title' => 'Temperature Converter - Celsius, Fahrenheit, Kelvin', 'description' => 'Free temperature converter. Convert between Celsius, Fahrenheit, and Kelvin instantly with formulas and step-by-step explanations.'],
            'time-converter' => ['title' => 'Time Converter', 'description' => 'Convert between seconds, minutes, hours, days, weeks, months, years.'],
            'timezone-converter' => ['title' => 'Timezone Converter', 'description' => 'Convert time between UTC offsets.'],
            'torque-converter' => ['title' => 'Torque Converter', 'description' => 'Convert between Newton-meters, foot-pounds, and more.'],
            'unix-timestamp-converter' => ['title' => 'Unix Timestamp Converter', 'description' => 'Convert between Unix timestamps and dates.'],
            'volume-converter' => ['title' => 'Volume Converter', 'description' => 'Convert between liters, gallons, cups, fluid ounces, etc.'],
            'weight-converter' => ['title' => 'Weight Converter - Convert Between Mass Units', 'description' => 'Free weight converter. Convert between kilograms, pounds, ounces, grams, stones, and more mass units instantly.'],
        ],
        'weather' => [
            'barometric-pressure-calculator' => ['title' => 'Barometric Pressure at Altitude', 'description' => 'Calculate atmospheric pressure at different altitudes.'],
            'celsius-to-fahrenheit-calculator' => ['title' => 'Celsius to Fahrenheit Calculator', 'description' => 'Convert temperature from Celsius to Fahrenheit.'],
            'dew-point-calculator' => ['title' => 'Dew Point Calculator', 'description' => 'Calculate the dew point temperature.'],
            'fahrenheit-to-celsius-calculator' => ['title' => 'Fahrenheit to Celsius Calculator', 'description' => 'Convert temperature from Fahrenheit to Celsius.'],
            'heat-index-calculator' => ['title' => 'Heat Index Calculator', 'description' => 'Calculate the apparent temperature (feels like) from temperature and humidity.'],
            'rainfall-calculator' => ['title' => 'Rainfall Volume Calculator', 'description' => 'Calculate water volume from rainfall depth and area.'],
            'uv-index-calculator' => ['title' => 'UV Index Risk Calculator', 'description' => 'Determine sun safety based on UV index.'],
            'wind-chill-calculator' => ['title' => 'Wind Chill Calculator', 'description' => 'Calculate the wind chill temperature.'],
        ],
    ];

    /**
     * Get all tools in a category
     */
    public static function getToolsByCategory(string $category): array
    {
        return self::$tools[$category] ?? [];
    }

    /**
     * Get all categories with their tools
     */
    public static function getAllTools(): array
    {
        return self::$tools;
    }

    /**
     * Get a specific tool
     */
    public static function getTool(string $category, string $slug): ?array
    {
        return self::$tools[$category][$slug] ?? null;
    }

    /**
     * Find which category a tool belongs to
     */
    public static function findCategory(string $slug): ?string
    {
        foreach (self::$tools as $cat => $tools) {
            if (isset($tools[$slug])) {
                return $cat;
            }
        }
        return null;
    }

    /**
     * Get total tool count
     */
    public static function getToolCount(): int
    {
        $count = 0;
        foreach (self::$tools as $tools) {
            $count += count($tools);
        }
        return $count;
    }

    /**
     * Get random tools for internal linking
     */
    public static function getRandomTools(int $count = 6, ?string $excludeSlug = null, ?string $excludeCategory = null): array
    {
        $all = [];
        foreach (self::$tools as $cat => $tools) {
            foreach ($tools as $slug => $info) {
                if ($slug !== $excludeSlug) {
                    $all[] = array_merge($info, ['slug' => $slug, 'category' => $cat]);
                }
            }
        }
        shuffle($all);
        return array_slice($all, 0, $count);
    }

    /**
     * Get tools from same category for internal linking
     */
    public static function getSameCategoryTools(string $category, string $excludeSlug, int $count = 4): array
    {
        $tools = self::$tools[$category] ?? [];
        unset($tools[$excludeSlug]);
        $result = [];
        $keys = array_keys($tools);
        shuffle($keys);
        foreach (array_slice($keys, 0, $count) as $slug) {
            $result[] = array_merge($tools[$slug], ['slug' => $slug, 'category' => $category]);
        }
        return $result;
    }

    /**
     * Get cross-category tools for internal linking
     */
    public static function getCrossCategoryTools(string $excludeCategory, int $count = 4): array
    {
        $all = [];
        foreach (self::$tools as $cat => $tools) {
            if ($cat === $excludeCategory) continue;
            $keys = array_keys($tools);
            if (!empty($keys)) {
                $slug = $keys[array_rand($keys)];
                $all[] = array_merge($tools[$slug], ['slug' => $slug, 'category' => $cat]);
            }
        }
        shuffle($all);
        return array_slice($all, 0, $count);
    }

    /**
     * Get popular/featured tools for homepage and footer
     */
    public static function getPopularTools(int $count = 8): array
    {
        $baseUrl = config('site.url');
        $categories = config('site.categories', []);
        $popular = [];
        foreach (self::$tools as $cat => $tools) {
            $keys = array_keys($tools);
            if (!empty($keys)) {
                $slug = $keys[0];
                $popular[] = array_merge($tools[$slug], [
                    'slug' => $slug,
                    'category' => $categories[$cat]['name'] ?? ucfirst($cat),
                    'categorySlug' => $cat,
                    'url' => $baseUrl . '/' . $cat . '/' . $slug,
                ]);
            }
        }
        shuffle($popular);
        return array_slice($popular, 0, $count);
    }

    /**
     * Get all categories with tool counts
     */
    public static function getCategoriesWithCounts(): array
    {
        $result = [];
        foreach (self::$tools as $cat => $tools) {
            $result[$cat] = count($tools);
        }
        return $result;
    }

    /**
     * Search tools by keyword
     */
    public static function searchTools(string $query): array
    {
        $query = strtolower($query);
        $results = [];
        foreach (self::$tools as $cat => $tools) {
            foreach ($tools as $slug => $info) {
                if (
                    str_contains(strtolower($info['title']), $query) ||
                    str_contains(strtolower($info['description']), $query) ||
                    str_contains(strtolower($slug), $query)
                ) {
                    $results[] = array_merge($info, ['slug' => $slug, 'category' => $cat]);
                }
            }
        }
        return $results;
    }

    /**
     * Alias: Get all tools grouped by category
     */
    public static function all(): array
    {
        return self::$tools;
    }

    /**
     * Alias: Get tools for a specific category
     */
    public static function forCategory(string $category): array
    {
        return self::$tools[$category] ?? [];
    }

    /**
     * Get related tools for internal linking (same + cross category)
     */
    public static function getRelatedTools(string $category, string $slug, int $sameCount = 4, int $crossCount = 4): array
    {
        $baseUrl = config('site.url');
        $categories = config('site.categories', []);
        $sameCategory = [];
        $crossCategory = [];

        // Same category tools
        $sameCat = self::$tools[$category] ?? [];
        unset($sameCat[$slug]);
        $sameKeys = array_keys($sameCat);
        shuffle($sameKeys);
        foreach (array_slice($sameKeys, 0, $sameCount) as $s) {
            $sameCategory[] = array_merge($sameCat[$s], [
                'slug' => $s,
                'category' => $categories[$category]['name'] ?? ucfirst($category),
                'url' => $baseUrl . '/' . $category . '/' . $s,
            ]);
        }

        // Cross category tools
        foreach (self::$tools as $cat => $tools) {
            if ($cat === $category) continue;
            $keys = array_keys($tools);
            if (!empty($keys)) {
                $s = $keys[array_rand($keys)];
                $crossCategory[] = array_merge($tools[$s], [
                    'slug' => $s,
                    'category' => $categories[$cat]['name'] ?? ucfirst($cat),
                    'url' => $baseUrl . '/' . $cat . '/' . $s,
                ]);
            }
            if (count($crossCategory) >= $crossCount) break;
        }

        return [
            'sameCategory' => $sameCategory,
            'crossCategory' => $crossCategory,
        ];
    }

    /**
     * Get category links with counts
     */
    public static function getCategoryLinks(): array
    {
        $baseUrl = config('site.url');
        $categories = config('site.categories', []);
        $result = [];
        foreach ($categories as $slug => $cat) {
            $toolCount = count(self::$tools[$slug] ?? []);
            if ($toolCount > 0) {
                $result[] = [
                    'slug' => $slug,
                    'name' => $cat['name'] ?? ucfirst($slug),
                    'count' => $toolCount,
                    'toolCount' => $toolCount,
                    'color' => $cat['color'] ?? 'gray',
                    'url' => $baseUrl . '/' . $slug,
                ];
            }
        }
        return $result;
    }
}