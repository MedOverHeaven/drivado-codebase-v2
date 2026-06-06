pipeline {
    agent any

    options {
        timestamps()
        timeout(time: 30, unit: 'MINUTES')
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }

  environment {
    PHP_BIN = "C:\\xampp\\php\\php.exe"
    COMPOSER_BIN = "C:\\laragon\\bin\\composer\\composer.bat"
}

    stages {
        stage('Checkout') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Checkout"
                    echo "=========================================="
                }
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/main']],
                    userRemoteConfigs: [[url: 'https://github.com/MedOverHeaven/drivado-codebase-v2.git']]
                ])
            }
        }

        stage('Environment Setup') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Environment Setup"
                    echo "=========================================="
                    if (!fileExists('.env')) {
                        bat 'copy .env.example .env'
                    }
                    bat '%PHP_BIN% --version'
                }
            }
        }

        stage('Dependencies') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Dependencies"
                    echo "=========================================="
                }
                bat '%COMPOSER_BIN% install --no-interaction --prefer-dist --no-progress'
            }
        }

        stage('Key Generation') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Key Generation"
                    echo "=========================================="
                }
                bat '%PHP_BIN% artisan key:generate'
            }
        }

        stage('Database Migration') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Database Migration"
                    echo "=========================================="
                }
                bat '%PHP_BIN% artisan migrate --force --env=testing'
            }
        }

        stage('Tests') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Tests"
                    echo "=========================================="
                    def result = bat(
                        script: 'php artisan test --no-coverage > test-output.txt 2>&1',
                        returnStatus: true
                    )
                    bat 'type test-output.txt'
                    if (result != 0) {
                        unstable("Tests failed")
                    }
                }
            }
        }
    }

    post {
        success {
            echo "✅ BUILD PASSED - Tous les tests sont passés!"
        }
        unstable {
            echo "⚠️ BUILD UNSTABLE - Certains tests ont échoué"
        }
        failure {
            echo "❌ BUILD FAILED - Le pipeline a rencontré des erreurs"
        }
    }
}